<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice Aflee</title>

    <style>
        #customers {
          font-family: Arial, Helvetica, sans-serif;
          border-collapse: collapse;
          width: 100%;
          font-size:xx-small;
        }
        
        #customers td, #customers th {
          border: 1px solid #ddd;
          padding: 8px;
        }
        
        #customers tr:nth-child(even){background-color: #f2f2f2;}
        
        #customers tr:hover {background-color: #ddd;}
        
        #customers th {
          padding-top: 12px;
          padding-bottom: 12px;
          text-align: left;
          background-color: #04AA6D;
          color: white;
        }
    </style>
</head>
<body>
    <center>
        {{-- <img style="width: 10%" src="{{$imgscr}}" alt=""> --}}
        <h2>Atqiya's Fun Learning Edukasi (Afledu)</h2>
    </center>
    <h4>Rekap Mengajar {{$sortedAflerName}} <br> {{$finalStartDate}} hingga {{$finalEndDate}}</h4>

    <table id="customers">
      <tr>
        <th>No</th>
        <th>Tanggal</th>
        <th>Afler</th>
        <th>Aflee</th>
        <th>Kelas</th>
        <th>Lokasi</th>
        <th>Jumlah Siswa</th>
        <th>Fee/Sesi</th>
        <th>Jumlah Sesi</th>
        <th>Fee Total</th>
        <th>Ongkos</th>
        <th>Total Fee</th>
      </tr>
      @php( $no = 1 )
      @foreach ($schedules as $schedule)
      <tr>
        <td>{{ $no++ }}</td>
        <td>{{ $schedule->date }}</td>
        <td> {{ isset($schedule->afler->afler_name) ? $schedule->afler->afler_name : '' }} </td>
        <td> {{ isset($schedule->aflee->aflee_name) ? $schedule->aflee->aflee_name : '' }} </td>
        <td> {{ isset($schedule->grade->level) ? $schedule->grade->level : '' }} </td>
        <td> {{ isset($schedule->location()->place_name) ? $schedule->location()->place_name : '' }} </td>
        <td> {{ $schedule->sum_student }} </td>
        <td> {{ number_format($schedule->fee_per_session) }} </td>
        <td> {{ $schedule->sum_session }} </td>
        <td> {{ number_format($schedule->fee_per_session*$schedule->sum_session) }} </td>
        <td>{{ isset($schedule->location()->cost) ? number_format($schedule->location()->cost) : '' }}</td>
        <td> {{ number_format($schedule->total_fee) }} </td>
      </tr>
      @endforeach

      <tr>
        <td colspan="11" style="text-align:center; background-color:aqua; font-weight: bold;"> TOTAL Seluruh Fee </td>
        <td style="background-color:gold; font-weight: bold;"> {{ number_format($totalFee) }} </td>
      </tr>
    </table>
    
</body>
</html>