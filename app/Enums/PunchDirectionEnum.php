<?php

namespace App\Enums;

enum PunchDirectionEnum: string
{
  case IN = 'in';
  case OUT = 'out';

  public function label(): string
  {
    return match ($this) {
      self::IN => 'Είσοδος',
      self::OUT => 'Έξοδος',
    };
  }

  public function color(): string
  {
    return match ($this) {
      self::IN => '#10b981',
      self::OUT => '#3b82f6',
    };
  }

  public function resource(): array
  {
    return [
      'value' => $this->value,
      'label' => $this->label(),
      'color' => $this->color()
    ];
  }
}
