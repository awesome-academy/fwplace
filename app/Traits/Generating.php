<?php
/**
 * Created by PhpStorm.
 * User: jakelagger
 * Date: 27/11/2018
 * Time: 15:40
 */

namespace App\Traits;

use Carbon\Carbon;

trait Generating
{
    public function renderSeat($workspace)
    {
        $totalSeat = $workspace->total_seat;
        $seatPerRow = $workspace->seat_per_row;
        $remainderSeat = $totalSeat % $seatPerRow; // Lấy số ghế dư ra

        if ($remainderSeat > 0) {
            $totalRow = floor($totalSeat / $seatPerRow) + 1; // Lấy số hàng, nếu có dư thì +1 hàng để lưu số dư
        } else {
            $totalRow = floor($totalSeat / $seatPerRow);
        }
        $alphabet = range('A', 'Z'); // Tạo ra bảng chữ cái để đặt tên cho cột
        $columnName = $alphabet;
        if ($seatPerRow > count($alphabet)) {
            // Nếu như số ghế/hàng > bảng chữ cái thì sẽ kết hợp thêm 1 bảng chữ cái nữa: AA, AB, AC,...
            foreach ($alphabet as $char) {
                foreach ($alphabet as $additionalChar) {
                    $columnName[] = $char . $additionalChar;
                }
            }
        }

        $columnList = array_slice($columnName, 0, $seatPerRow); // Lấy danh sách tên các hàng
        $rowList = range(1, $totalRow); // Lấy danh sách tên các cột
        $renderSeat = [];
        $counting = 0; // Đếm số ghế được tạo ra
        foreach ($rowList as $key => $row) {
            foreach ($columnList as $column) {
                $counting++;
                if ($counting <= $totalSeat) {
                    // Chưa max thì sẽ thêm
                    $renderSeat[$row][] = $column . $row;
                } else {
                    // Nếu max thì thêm để tạo đủ ghế
                    $renderSeat[$row][] = null;
                }
            }
        }

        return $renderSeat;
    }

    public function getColorLocation($locations)
    {
        $colorLocation = [];
        foreach ($locations as $key => $location) {
            foreach ($location->seats as $id => $seat) {
                $colorLocation[$key][$id]['location'] = $location->name;
                $colorLocation[$key][$id]['seat_id'] = $seat->id;
                $colorLocation[$key][$id]['name'] = $seat->name;
                $colorLocation[$key][$id]['color'] = $location->color;
                $colorLocation[$key][$id]['position_id'] = $seat->position_id;
                $colorLocation[$key][$id]['usable'] = $seat->usable;
                $colorLocation[$key][$id]['location_id'] = $seat->location_id;
            }
        }
        $colorLocation = json_encode($colorLocation);

        return $colorLocation;
    }

    public function getWorkingDatesInMonth()
    {
        $dates = [];
        for ($i = 0; $i < 31; $i++) {
            $day = Carbon::now()->startOfMonth()->addDay($i);
            if (!$day->isWeekend()) {
                $dates += [$i => $day->format('Y-m-d')];
            }
        }

        return $dates;
    }
}
