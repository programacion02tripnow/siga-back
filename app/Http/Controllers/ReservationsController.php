<?php

namespace App\Http\Controllers;

use App\Exports\CommissionsReport;
use App\Exports\ReservationsExport;
use App\Exports\UserCommissionsReport;
use App\Mail\PendingPayment;
use App\Mail\ReservationConfirmation;
use App\Models\CarRentalReservation;
use App\Models\Log;
use App\Models\Multimedia;
use App\Models\Refund;
use App\Models\Reservation;
use App\Models\ReservationComment;
use App\Models\ReservationDetail;
use App\Models\ReservationDetailAge;
use App\Models\ReservationDetailComment;
use App\Models\ReservationPayment;
use App\Models\ReservationPaymentAdditionalValue;
use App\Models\ReservationPaymentDate;
use App\Models\Settlement;
use App\Models\CustomerWallet;
use App\Strategies\ReservationDetailContext;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use mysql_xdevapi\Exception;

class ReservationsController extends MainController
{
    protected $model = Reservation::class;

    protected function getValidations(): array
    {
        $result = [
            'customer_id' => 'required|exists:customers,id',
            'editable' => 'required',
            'cancelable' => 'required',
            'with_payments' => 'required',
            'reservation_payment_dates' => Rule::requiredIf(request()->input('with_payments')),
            'reservation_details' => 'required',
        ];
        $request = request();
        if ($request->isMethod('PUT')) {
            $result['id'] = 'required';
        }

        return $result;
    }

    protected function getMessages(): array
    {
        return [
            'customer_id.required' => 'Debe indicar el cliente',
            'customer_id.exists' => 'El cliente seleccionado no existe',
            'editable.required' => 'Debe indicar si la reserva puede editarse',
            'cancelable.required' => 'Debe indicar si la reserva puede cancelarse',
            'with_payments.required' => 'Debe indicar si la reserva requiere pago(s)',
            'reservation_payment_dates.required_if' => 'La reserva requiere pago(s)',
            'reservation_details.required' => 'Debe incluir los detalles de la reserva',
            'id.required' => 'Se debe especificar el código del canal a editar'
        ];
    }

    public function save($model, Request $request)
    {
        if ($request->isMethod('put')) {
            $prev = $this->get_form_info($model->id, false);
            $this->create_model_log($prev, false);
        }

        if ($request->isMethod('POST')) {
            $model->user_id = $request->input('user_id');
        } else {
            if ($request->input('user_id')) {
                $model->user_id = $request->input('user_id');
            }
        }
        $model->edited_by_id = Auth::id();
        $model->customer_id = $request->input('customer_id');
        $model->editable = $request->input('editable');
        $model->cancelable = $request->input('cancelable');
        $model->with_payments = $request->input('with_payments');
        $model->paid_to_provider = $request->input('paid_to_provider');
        $model->public_price = $request->input('public_price');
        $model->net_price = $request->input('net_price');
        $model->added_price = $request->input('added_price') ?? 0;
        $model->save();


        $model->reservation_payment_dates()->delete();
        // if ($request->input('with_payments')) {
        //     foreach ($request->input('reservation_payment_dates') as $reservation_payment) {
        //         $rp = new ReservationPaymentDate();
        //         $rp->reservation_id = $model->id;
        //         $rp->amount = $reservation_payment['amount'];
        //         $rp->date = $reservation_payment['date'];
        //         if (isset($reservation_payment['reservation_payment_id'])) {
        //             $rp->reservation_payment_id = $reservation_payment['reservation_payment_id'];
        //         }
        //         $rp->save();
        //     }
        // }

        if ($request->isMethod('POST')) {
            $model->booking_id = strtoupper(bin2hex(random_bytes(2))) . '-' . $model->id;
            $model->save();

            $model->reservation_payments()->delete();
            foreach ($request->input('reservation_payments') as $reservation_payment) {
                $rp = new ReservationPayment();
                $rp->reservation_id = $model->id;
                $rp->amount = $reservation_payment['amount'];
                $rp->date = date('Y-m-d H:i:s'); //$reservation_payment['date'];
                $rp->payment_method_id = $reservation_payment['payment_method_id'];
                $rp->payment_method_text = $reservation_payment['payment_method_text'];
                $rp->user_id = $reservation_payment['user_id'] ?? Auth::id();
                $rp->save();
                foreach ($reservation_payment['reservation_payment_additional_values'] as $value) {
                    $rpv = new ReservationPaymentAdditionalValue();
                    $rpv->reservation_payment_id = $rp->id;
                    $rpv->payment_method_additional_field_id = $value['payment_method_additional_field_id'];
                    $rpv->value = $value['value'];
                    $rpv->save();
                }
            }
        }

        $model->reservation_comments()->delete();
        foreach ($request->input('reservation_comments') as $reservation_comment) {
            $rc = new ReservationComment();
            $rc->reservation_id = $model->id;
            $rc->user_id = Auth::id();
            $rc->comment($reservation_comment['comment']);
            $rc->save();
        }

        $model->reservation_details()->delete();
        foreach ($request->input('reservation_details') as $r) {
            $modelClass = $r['reservable_type'];
            $class = $modelClass::$strategy;
            $strategy = new $class();
            $context = new ReservationDetailContext($strategy);
            $reservable = $context->execute_strategy($r);

            $modelName = class_basename($modelClass);
            $modelName = Str::replaceFirst('App\\Models\\', '', $modelName);
            $modelName = Str::replaceFirst('Reservation', '', $modelName);
            $commissionType = Str::plural(Str::snake($modelName)) . "_commission";

            $detail = new ReservationDetail();
            $detail->reservation_id = $model->id;
            $detail->user_id = Auth::id();
            $detail->reservable_id = $reservable->id;
            $detail->reservable_type = $r['reservable_type'];
            $detail->public_price = $r['public_price'];
            $detail->net_price = $r['net_price'];
            $detail->added_price = $r['added_price'] ?? 0;
            $detail->provider_id = $r['provider_id'];
            $detail->cancellable = $r['cancellable'];
            $detail->editable = $r['editable'];
            $detail->refundable = $r['refundable'];
            $detail->terms_conditions = $r['terms_conditions'];
            $detail->provider_confirmation_number = $r['provider_confirmation_number'];
            $detail->invoiced = $r['invoiced'];
            if (isset($r['cancelled_at'])) {
                $detail->cancelled_at = $r['cancelled_at'];
                $detail->cancelled_by_id = $r['cancelled_by_id'];
            }
            $detail->agent_commission = (($r['public_price'] - $r['net_price']) * $model->user->$commissionType) / 100;

            $detail->save();

            if (isset($r['settlement'])) {
                $settlement = Settlement::find($r['settlement']['id']);
                if ($settlement) {
                    $settlement->reservation_detail_id = $detail->id;
                    $settlement->save();
                }
            }

            foreach ($r['reservation_detail_comments'] as $comment) {
                if ($comment['comment'] !== null && $comment['comment'] !== '') {
                    $rdc = new ReservationDetailComment();
                    $rdc->reservation_detail_id = $detail->id;
                    $rdc->comment = $comment['comment'];
                    $rdc->user_id = Auth::id();
                    $rdc->save();
                }
            }

            if ($detail->detail_needs_ages()) {
                foreach ($r['reservation_detail_ages'] as $age) {
                    $a = new ReservationDetailAge();
                    $a->reservation_detail_id = $detail->id;
                    $a->age = isset($age['id']) ? $age['age'] : $age;
                    $a->save();
                }
            }

            if (isset($r['multimedia'])) {
                if (isset($r['multimedia']['id'])) {
                    $detail->multimedia_id = $r['multimedia']['id'];
                } else {
                    $this->create_image($r['multimedia']['file_url'], '/vouchers/', $r['multimedia']['filename']);

                    $m = new Multimedia();
                    $m->filename = $r['multimedia']['filename'];
                    $m->file_url = url(Storage::url('vouchers/' . $m->filename));
                    $m->save();

                    $detail->multimedia_id = $m->id;
                }
                $detail->save();
            }

        }

        $model = $model->refresh();

        if ($model->status === 1 && $request->isMethod('POST')) {
            Mail::send(new PendingPayment($model));
        } elseif ($model->status === 2) {
            Mail::send(new ReservationConfirmation($model));
        }

        return $model;
    }

    public function get_form_info($reservation_id, $is_request = true)
    {
        $data = [
            'result' => 'success',
        ];
        $status_code = 200;
        try {
            $reservation = Reservation::with(['customer','user.multimedia', 'edited_by.multimedia', 'reservation_payments.reservation_payment_additional_values', 'reservation_payments.user.multimedia', 'reservation_payment_dates.reservation_payment', 'reservation_comments', 'reservation_details.reservable', 'reservation_details.multimedia', 'reservation_details.settlement.authorization_user', 'reservation_details.settlement.user', 'reservation_details.reservation_detail_ages', 'reservation_details.reservation_detail_comments.user', 'reservation_details.cancelled_by.multimedia'])->find($reservation_id);
            if (!$reservation) {
                throw new \Exception('No se encontró la reserva', 404);
            }
            for ($i = 0; $i < count($reservation->reservation_details); $i++) {
                $reservation->reservation_details[$i]->reservable->loadRelations();
            }
            $data['data'] = $reservation;
        } catch (\Exception $ex) {
            $data['result'] = 'error';
            $data['error'] = $ex->getMessage();
            $status_code = $ex->getCode();
        }


        return $is_request ? Response()->json($data, $status_code, [], JSON_NUMERIC_CHECK)->setStatusCode($status_code) : $data['data'];
    }

    public function save_reservation_detail_comment(Request $request)
    {
        $comment = new ReservationDetailComment();
        $comment->user_id = Auth::id();
        $comment->reservation_detail_id = $request->input('reservation_detail_id');
        $comment->comment = $request->input('comment');
        $comment->save();

        $comment->user;

        return Response()->json(['result' => 'success', 'data' => $comment], 200, [], JSON_NUMERIC_CHECK)->setStatusCode(200);
    }

    public function cancel_service($reservation_detail_id, $is_request = true)
    {
        $data = [
            'result' => 'success',
        ];
        $status_code = 200;

        try {
            $reservation_detail = ReservationDetail::find($reservation_detail_id);
            if (!$reservation_detail) {
                throw new \Exception('No se encontró el servicio', 404);
            }
            // if (!$reservation_detail->cancellable) {
            //     throw new \Exception('El servicio no se ha marcado como no cancelable', 403);
            // }

            $prev = $this->get_form_info($reservation_detail->reservation_id, false);
            $this->create_model_log($prev, false);

            $reservation_detail->cancellable = false;
            $reservation_detail->editable = false;
            $reservation_detail->cancelled_at = date('Y-m-d H:i:s');
            $reservation_detail->cancelled_by_id = Auth::id();
            $reservation_detail->save();

            //Refund
            $reservation = $reservation_detail->reservation;


            // $customerWallet = $reservation->customer->customer_wallets;
            // return $is_request ? Response()->json($customerWallet, $status_code, [], JSON_NUMERIC_CHECK)->setStatusCode($status_code) : $data['data'];

            if (count($reservation->reservation_payments) > 0 ) {
                $paid = $reservation->reservation_payments->sum('amount');
                $new_public = $reservation->public_price - $reservation_detail->public_price;
                $refund_total = $paid - $new_public;


                if($paid <= $reservation_detail->public_price) {
                    $refund_total = $paid;
                }

                if ($refund_total > 0) {
                    $refund = new Refund();
                    $refund->reservation_detail_id = $reservation_detail->id;
                    $refund->reservation_id = $reservation_detail->reservation_id;
                    $refund->amount = abs($refund_total);
                    $refund->token = bin2hex(random_bytes(5));
                    $refund->status = 1;
                    $refund->user_id = Auth::id();
                    $refund->save();

                    $wallet = CustomerWallet::create([
                        'customer_id' => $reservation->customer_id,
                        'amount' => abs($refund_total),
                        'reservation_detail_id' => $reservation_detail->id
                    ]);

                    $customerWallet = $reservation->customer->customer_wallets;

                    //return $is_request ? Response()->json($customerWallet->sum('amount'), $status_code, [], JSON_NUMERIC_CHECK)->setStatusCode($status_code) : $data['data'];
                    $totalWallet = $customerWallet->sum('amount');
                    $reservation->customer->update([
                        'wallet' => abs($totalWallet)
                    ]);

                }
            }

            // $data['data'] = $reservation_detail;
        } catch (\Exception $ex) {
            $data['result'] = 'error';
            $data['error'] = $ex->getMessage();
            $status_code = 500;
        }

        return $is_request ? Response()->json($data, $status_code, [], JSON_NUMERIC_CHECK)->setStatusCode($status_code) : $data['data'];
    }

    public function get_logs($reservation_id)
    {
        $data = [
            'result' => 'success',
        ];
        $status_code = 200;
        try {
            $logs = Log::with(['user'])->where('logable_type', Reservation::class)->where('logable_id', $reservation_id)->orderBy('id', 'DESC')->get();
            $data['data'] = $logs;
        } catch (\Exception $ex) {
            $data['result'] = 'error';
            $data['error'] = $ex->getMessage();
            $status_code = 500;
        }

        return Response()->json($data, $status_code, [], JSON_NUMERIC_CHECK)->setStatusCode($status_code);
    }

    public function voucher($id)
    {
        try {
            $reservation_detail = ReservationDetail::find($id);
            return PDF::setOptions(
                [
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                    'chroot' => public_path(),
                ])->loadView('pdf.voucher', ['reservation_detail' => $reservation_detail])->stream();
        } catch (\Exception $ex) {
            $data['result'] = 'error';
            $data['error'] = $ex->getMessage();
            $status_code = $ex->getCode();
            return response()->json($data)->setStatusCode($status_code);
        }
    }

    public function reservations_export(Request $request)
    {
        try {
            $data = [
                'result' => 'success',
            ];
            try {
                $filename = 'reservations_report_' . bin2hex(random_bytes(10)) . '.xlsx';
                $reservations = $this->filter(Reservation::with([]), $request->input('filter'));
                $reservations = $reservations->get();
                header('Content-disposition: attachment; filename=' . $filename);
                return Excel::download(new ReservationsExport($reservations), $filename);
            } catch (\Exception $ex) {
                $data['result'] = 'error';
                $data['error'] = $ex->getMessage();
                $status_code = 200;
            }
            return response()->json($data)->setStatusCode($status_code);
        } catch (\Exception $ex) {
            return response()->json($ex->getMessage())->setStatusCode(200);
        }

    }

    public function validateDestroy($model): bool
    {
        foreach ($model->reservation_details as $rd) {
            $this->cancel_service($rd->id);
        }
        return false;
    }

    public function validate_refund($token){
        $data = [
            'result' => 'success',
        ];
        $status_code = 200;
        try {
            $refund = Refund::where('token', $token)->where('status', 1)->first();
            if (!$refund) {
                throw new \Exception('El código del monedero no es válido o ya se ha usado', 404);
            }
            $data['data'] = $refund;
        } catch (\Exception $ex) {
            $data['result'] = 'error';
            $data['error'] = $ex->getMessage();
            $status_code = 500;
        }

        return Response()->json($data, $status_code, [], JSON_NUMERIC_CHECK)->setStatusCode($status_code);
    }

    public function commissions_export(Request $request)
    {
        try {
            $data = [
                'result' => 'success',
            ];
            try {
                $filename = 'commissions_report_' . bin2hex(random_bytes(10)) . '.xlsx';

                header('Content-disposition: attachment; filename=' . $filename);
                return Excel::download(new CommissionsReport($request), $filename);
            } catch (\Exception $ex) {
                $data['result'] = 'error';
                $data['error'] = $ex->getMessage();
                $status_code = 200;
            }
            return response()->json($data)->setStatusCode($status_code);
        } catch (\Exception $ex) {
            return response()->json($ex->getMessage())->setStatusCode(200);
        }
    }
    public function user_commissions_export(Request $request){
        try {
            $data = [
                'result' => 'success',
            ];
            try {
                $filename = 'user_commissions_report_' . bin2hex(random_bytes(10)) . '.xlsx';

                header('Content-disposition: attachment; filename=' . $filename);
                return Excel::download(new UserCommissionsReport($request), $filename);
            } catch (\Exception $ex) {
                $data['result'] = 'error';
                $data['error'] = $ex->getMessage();
                $status_code = 200;
            }
            return response()->json($data)->setStatusCode($status_code);
        } catch (\Exception $ex) {
            return response()->json($ex->getMessage())->setStatusCode(200);
        }
    }
}
