<?php

namespace App\Enums;

enum RoleEnum: string
{
  case SUPERADMIN = 'superadmin';
  case ADMIN = 'admin';
  case EDITOR = 'editor';

  public function label(): string
  {
    return match ($this) {
      self::SUPERADMIN => 'Υπέρ-Διαχειριστής',
      self::ADMIN => 'Διαχειριστής',
      self::EDITOR => 'Συντάκτης',
    };
  }

  public function color(): string
  {
    return match ($this) {
      static::SUPERADMIN => '#1E293B',
      static::ADMIN => '#0EA5E9',
      static::EDITOR => '#F59E0B',
    };
  }
}
