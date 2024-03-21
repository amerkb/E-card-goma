<?php

namespace App\Repository\Dashboard;

use App\Http\Resources\UserResource;
use App\Interfaces\Dashboard\UserInterface;
use App\Models\User;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class UserRepository implements UserInterface
{
    public function index()
    {
        $users = User::all();

        return UserResource::collection($users);

    }

    public function store($request)
    {
        $request->validated();

        $user = User::create(array_merge($request->except('password'),
            ['password' => md5($request->password)]
        ));

        return UserResource::make($user);
    }

    public function store_user_by_number($request)
    {
        $lastUser = User::MAX('id');
        $users = [];
        $password = [];

        // Perform the operations or code you want to measure

        for ($i = 0; $i < $request->number; $i++) {
            $password[$i] = rand(100000, 999999);
            $users[$i] = [
                'id' => $lastUser + 1 + $i,
                'password' => md5($password[$i]),
                'userName' => 'goma'.$lastUser + 1 + $i,
                'uuid' => Str::uuid(),
                'is_admin' => false,
            ];

        }
        User::insert($users);

        //         Create a new Excel file
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        $sheet->setCellValue('A1', 'user_id');
        $sheet->setCellValue('B1', 'Goma');
        $sheet->setCellValue('C1', 'Password');
        $sheet->setCellValue('D1', 'uuid');
        $sheet->setCellValue('E1', 'link');

        $cellRange1 = 'A'. 1 .':E'. 1;
        $this->styling_sheet($sheet, $cellRange1);

        // Populate user data
        foreach ($users as $index => $user) {

            $row = $index + 2;
            $sheet->setCellValue('A'.$row, $user['id']);
            $sheet->setCellValue('B'.$row, $user['userName']);
            $sheet->setCellValue('C'.$row, $password[$index]);
            $sheet->setCellValue('D'.$row, $user['uuid']);
            $sheet->setCellValue('E'.$row, 'Bcard.gomaksa.com?user='.$user['uuid']);

            // Set cell styling and spacing
            $cellRange = 'A'.$row.':E'.$row;
            $this->styling_sheet($sheet, $cellRange);
        }

        // Set the file name and save the Excel file
        $fileName = 'users.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save($fileName);

        // Return the file as a response
        return response()->download($fileName)->deleteFileAfterSend(true);

    }

    public function show(User $user)
    {
        return UserResource::make($user);

    }

    public function update($request, User $user)
    {
        $user->update(array_merge($request->except('password'),
            ['password' => md5($request->password)]
        ));

        return UserResource::make($user);
    }

    public function delete(User $user)
    {
        $user->delete();

        return response()->json(['message' => 'Deleted Successfully'], 404);
    }

    public function show_by_uuid(User $user)
    {
        return UserResource::make($user);

    }

    /**
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function styling_sheet(Worksheet $sheet, string $cellRange): void
    {
        $sheet->getStyle($cellRange)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle($cellRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($cellRange)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle($cellRange)->getAlignment()->setWrapText(true);
        $sheet->getStyle($cellRange)->getAlignment()->setIndent(1);
        $sheet->getStyle($cellRange)->getAlignment()->setShrinkToFit(true);
    }
}
