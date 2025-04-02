<?php

namespace App\Enums;

enum Status: string
{
    case Pending = 'pending';
    case Approved = 'approved';
    case Rejected = 'rejected';
    case Cancelled = 'cancelled';
    case Completed = 'completed';

    public function label(): string
    {
        return match($this) {
            self::Pending => 'Pendente',
            self::Approved => 'Aprovada',
            self::Rejected => 'Rejeitada',
            self::Cancelled => 'Cancelada',
            self::Completed => 'Concluída',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Pending => 'warning',
            self::Approved => 'success',
            self::Rejected => 'danger',
            self::Cancelled => 'secondary',
            self::Completed => 'info',
        };
    }
} 