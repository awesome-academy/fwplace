<?php

namespace App\Traits;

use Carbon\Carbon;

trait Generating
{
    public function renderSeat($location)
    {
        $seatPerColumn = $location->seat_per_column;
        $seatPerRow = $location->seat_per_row;
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
        $rowList = range(1, $seatPerColumn); // Lấy danh sách tên các cột
        $renderSeat = [];
        $counting = 0; // Đếm số ghế được tạo ra
        foreach ($columnList as $column) {
            foreach ($rowList as $key => $row) {
                $counting++;
                $renderSeat[$column][] = $column . $row;
            }
        }

        return $renderSeat;
    }

    public function getColorLocation($locations)
    {
        $colorLocation = [];
        foreach ($locations as $key => $location) {
            foreach ($location->seats as $id => $seat) {
                $userId = $this->userRepository->get();
                $listUserId = unserialize($seat->user_id);
                $colorLocation[$key][$id]['location'] = $location->name;
                $colorLocation[$key][$id]['seat_id'] = $seat->id;
                $colorLocation[$key][$id]['name'] = $seat->name;
                $colorLocation[$key][$id]['color'] = $location->color;
                $colorLocation[$key][$id]['position_id'] = $seat->position_id;
                $colorLocation[$key][$id]['usable'] = $seat->usable;
                $colorLocation[$key][$id]['location_id'] = $seat->location_id;
                if ($seat->user_id != null) {
                    $checkName = [];
                    $checkAvatar = [];
                    $checkUserId = [];
                    foreach ($userId as $value) {
                        if (in_array($value->id, $listUserId)) {
                            $checkAvatar[] = $value->avatar;
                            $checkUserId[] =  $value->id;
                            $checkName[] = $value->name;
                            $checkProgram = $value->program_id;
                            $position = $this->userRepository->findOrFail($value->id)->position->id;
                        }
                    }
                    $colorLocation[$key][$id]['user_name'] = $checkName;
                    $colorLocation[$key][$id]['avatar'] = $checkAvatar;
                    $colorLocation[$key][$id]['user_id'] = $checkUserId;
                    $colorLocation[$key][$id]['position'] = $position;
                    $colorLocation[$key][$id]['program'] = $checkProgram;
                } else {
                    $colorLocation[$key][$id]['user_name'] = $seat->name;
                    $colorLocation[$key][$id]['avatar'] = null;
                    $colorLocation[$key][$id]['user_id'] = null;
                    $colorLocation[$key][$id]['program'] = null;
                    $colorLocation[$key][$id]['position'] = null;
                }
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
