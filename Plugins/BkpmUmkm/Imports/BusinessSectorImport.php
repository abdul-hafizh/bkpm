<?php


namespace Plugins\BkpmUmkm\Imports;


use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;

class BusinessSectorImport implements OnEachRow, WithHeadingRow
{
    protected $businessSectorService;

    public function __construct()
    {
        $this->businessSectorService = app(\Plugins\BkpmUmkm\Services\BusinessSectorService::class);
    }

    public function onRow(Row $row)
    {
        // TODO: Implement onRow() method.
        $row      = $row->toArray();

        if (
            isset($row['name']) && !empty($row['name'])
        ) {

            $name = filter($row['name']);
            $slug = $this->businessSectorService->generateSlug('', $name);
            $data = [
                'slug' => $slug,
                'name' => $name,
            ];
            $businessSector = \Plugins\BkpmUmkm\Models\BusinessSectorModel::query()->updateOrCreate(['slug' => $data['slug']], $data);
            $logProperties['attributes'] = $businessSector->toArray();
            activity_log("LOG_BUSINESS_SECTOR", 'import', 'Your import <strong>Business Sector</strong>: ' . $data['name'], $logProperties, $businessSector);
        }
    }
}
