<?php

namespace App\Enum\Reservation;

enum Status : string {
    case Pending   = 'pending';
    case Approved  = 'approved';
    case Canceled  = 'canceled';
    case Rejected  = 'rejected';
    case Completed = 'completed';

    public function label(): string
    {

        return match ($this) {
            self::Pending   => 'Pendente, aguardando revisão do síndico',
            self::Approved  => 'Aprovado',
            self::Canceled  => 'Cancelado pelo residente',
            self::Rejected  => 'Rejeitado pelo síndico',
            self::Completed => 'Concluída. Reserva finalizada',
        };
    }
}

