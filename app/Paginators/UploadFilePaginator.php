<?php

namespace App\Paginators;

use App\Models\Views\UploadFileView;
use Artibet\Laralib\Abstracts\PaginatorBase;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\UploadFile\View as UploadFileViewResource;

class UploadFilePaginator extends PaginatorBase
{
  // ---------------------------------------------------------------------------------------
  // Override abstract method columns()
  // ---------------------------------------------------------------------------------------
  protected function columns(): array
  {
    return [
      ['id' => 'descr', 'type' => 'string'],
      ['id' => 'starts_at', 'type' => 'date'],
      ['id' => 'ends_at', 'type' => 'date'],
      ['id' => 'employees_count', 'type' => 'number'],
      ['id' => 'file_size', 'type' => 'number'],
      ['id' => 'created_at', 'type' => 'date'],
    ];
  }

  // ---------------------------------------------------------------------------------------
  // Override abstract method query()
  // ---------------------------------------------------------------------------------------
  protected function query(): Builder
  {
    return UploadFileView::query();
  }

  // ---------------------------------------------------------------------------------------
  // Override abstract method resourceClass()
  // ---------------------------------------------------------------------------------------
  protected function resourceClass(): string
  {
    return UploadFileViewResource::class;
  }
}
