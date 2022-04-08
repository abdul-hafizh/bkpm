<?php


namespace Plugins\BkpmUmkm\Imports;


use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;

class KbliImport implements OnEachRow, WithHeadingRow
{
    public function onRow(Row $row)
    {
        // TODO: Implement onRow() method.
        $row      = $row->toArray();

        if (
            (isset($row['name']) && !empty($row['name'])) &&
            (isset($row['code']) && !empty($row['code']))
        ) {
            $data = [
                'code'          => filter($row['code']),
                'parent_code'   => (!empty($row['parent_code']) ? $row['parent_code'] : NULL),
                'name'          => filter($row['name']),
                'description'   => filter($row['description'])
            ];

            /* kbli check */
            $kbli = \Plugins\BkpmUmkm\Models\KbliModel::where(['code' => $data['code']])->first();
            if (!$kbli) {
                $kbli = \Plugins\BkpmUmkm\Models\KbliModel::query()->updateOrCreate(['code' => $data['code']], $data);
                $logProperties['attributes'] = $kbli->toArray();
                activity_log("LOG_KBLI", 'import', 'Your import <strong>KBLI</strong>: [' . $data['code'] . '] ' . $data['name'], $logProperties, $kbli);
            }
        }
    }
}
