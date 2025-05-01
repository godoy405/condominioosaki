<?php

namespace App\Services;

use App\Models\ReservationModel;
use App\Entities\Reservation;

class NotifierService
{
    public function sendReservationCreatedNotification(Reservation $reservation): bool
    {
        try {
            $email = \Config\Services::email();
            
            // Log para debug
            log_message('debug', 'Iniciando envio de email de criação de reserva');
            log_message('debug', 'Email do residente: ' . $reservation->resident_email);
            
            // Configurações comuns
            $email->setFrom('gilbertonerigodoy@gmail.com', 'Sistema de Reservas');
            $email->setSubject('Nova Reserva Criada - ' . $reservation->area_name);
            
            // Enviar para o residente
            $email->setTo($reservation->resident_email);
            $message = view('emails/reservation_created', [
                'reservation' => $reservation
            ]);
            $email->setMessage($message);
            
            if (!$email->send(false)) { // false para não limpar os dados após envio
                log_message('error', 'Falha ao enviar email de criação para residente: ' . $email->printDebugger(['headers']));
                return false;
            }
            
            log_message('debug', 'Email enviado com sucesso para o residente');
            
            // Enviar para o síndico
            $syndic = get_syndic();
            $email->setTo('gilbertonerigodoy@gmail.com'); // Email do síndico hardcoded para teste
            $message = view('emails/reservation_created', [
                'reservation' => $reservation
            ]);
            $email->setMessage($message);
            
            if (!$email->send(false)) {
                log_message('error', 'Falha ao enviar email de criação para síndico: ' . $email->printDebugger(['headers']));
                return false;
            }
            
            log_message('info', 'Emails de criação de reserva enviados com sucesso');
            return true;
            
        } catch (\Exception $e) {
            log_message('error', 'Erro ao enviar notificações de criação: ' . $e->getMessage());
            log_message('error', 'Stack trace: ' . $e->getTraceAsString());
            return false;
        }
    }

    public function sendCancellationNotification(Reservation $reservation, string $reason): bool
    {
        try {
            $email = \Config\Services::email();
            
            // Log para debug
            log_message('debug', 'Iniciando envio de email de cancelamento de reserva');
            log_message('debug', 'Email do residente: ' . $reservation->resident_email);
            
            // Configurações comuns
            $email->setFrom('gilbertonerigodoy@gmail.com', 'Sistema de Reservas');
            $email->setSubject('Cancelamento de Reserva - ' . $reservation->area_name);
            
            // Enviar para o residente
            $email->setTo($reservation->resident_email);
            $message = view('emails/cancellation_notification', [
                'reservation' => $reservation,
                'reason' => $reason
            ]);
            $email->setMessage($message);
            
            if (!$email->send(false)) {
                log_message('error', 'Falha ao enviar email de cancelamento para residente: ' . $email->printDebugger(['headers']));
                return false;
            }
            
            log_message('debug', 'Email enviado com sucesso para o residente');
            
            // Enviar para o síndico
            $syndic = get_syndic();
            $email->setTo('gilbertonerigodoy@gmail.com'); // Email do síndico hardcoded para teste
            $message = view('emails/cancellation_notification', [
                'reservation' => $reservation,
                'reason' => $reason
            ]);
            $email->setMessage($message);
            
            if (!$email->send(false)) {
                log_message('error', 'Falha ao enviar email de cancelamento para síndico: ' . $email->printDebugger(['headers']));
                return false;
            }
            
            log_message('info', 'Emails de cancelamento enviados com sucesso');
            return true;
            
        } catch (\Exception $e) {
            log_message('error', 'Erro ao enviar notificações de cancelamento: ' . $e->getMessage());
            log_message('error', 'Stack trace: ' . $e->getTraceAsString());
            return false;
        }
    }
} 