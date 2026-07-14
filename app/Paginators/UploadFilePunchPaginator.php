<?php

namespace App\Paginators;

use App\Models\Views\PunchView;
use Artibet\Laralib\Abstracts\PaginatorBase;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Resources\Punch\View as PunchViewResource;

class UploadFilePunchPaginator extends PaginatorBase
{
  private int $uploadFileId;

  // ---------------------------------------------------------------------------------------
  // Override constructor to get upload_file_id
  // ---------------------------------------------------------------------------------------
  public function __construct(Request $request, int $uploadFileId)
  {
    parent::__construct($request);
    $this->uploadFileId = $uploadFileId;
  }

  // ---------------------------------------------------------------------------------------
  // Override abstract method columns()
  // ---------------------------------------------------------------------------------------
  protected function columns(): array
  {
    return [
      ['id' => 'am', 'type' => 'string'],
      ['id' => 'lastname', 'type' => 'string'],
      ['id' => 'firstname', 'type' => 'string'],
      ['id' => 'clock_code', 'type' => 'string'],
      ['id' => 'card_no', 'type' => 'string'],
      ['id' => 'shift_string', 'type' => 'string'],
      ['id' => 'direction_label', 'type' => 'string'],
      ['id' => 'punched_at', 'type' => 'date'],
    ];
  }

  // ---------------------------------------------------------------------------------------
  // Override abstract method query()
  // ---------------------------------------------------------------------------------------
  protected function query(): Builder
  {
    return PunchView::where('upload_file_id', $this->uploadFileId);
  }

  // ---------------------------------------------------------------------------------------
  // Override abstract method resourceClass()
  // ---------------------------------------------------------------------------------------
  protected function resourceClass(): string
  {
    return PunchViewResource::class;
  }
}
