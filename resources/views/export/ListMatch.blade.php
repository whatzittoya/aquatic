<?php
 function timeFormat($milisecond) {
      $hour = 0;
      $minute = 0;
      $second = 0;
      $mili = 0;

      $hour = floor($milisecond / 3600000);

      if (strlen($hour) < 2) {
        $hour = substr("0".$hour,-2);
      }
      $milisecond = $milisecond - $hour * 3600000;

      $minute = floor($milisecond / 60000);
      $minute = substr("0".$minute,-2);
      $milisecond = $milisecond - $minute * 60000;
      $second = floor($milisecond / 1000);
      $second = substr("0".$second,-2);
      $milisecond = $milisecond - $second * 1000;
      $mili = $milisecond;
      $mili = substr("00".$mili,-3);

      return $hour . ":" . $minute . ":" . $second . "." . $mili;
    }
?>

<table>
    <thead>
    <tr>
        <th>No</th>
        <th>Nama Klub</th>
        <th>Kota</th>
        <th>Provinsi</th>
        <th>PIC</th>
        <th>Nomor Telepon</th>
        
        <th>Nama member</th>
        <th>Gender</th>
        <th>Tanggal Lahir</th>
        <th>Tahun Lahir</th>
        <th>Event terakhir</th>
        <th>Nomor Lomba Terakhir</th>
        <th>Nama Lomba Terakhir</th>
        <th>Event</th>
        <th>Event Mulai</th>
        <th>Event Selesai</th>
        <th>Nomor Lomba</th>
        <th>Nama Lomba</th>
<th>Seri</th>
<th>Nomor Line</th>
        <th>Time Result</th>
        <th>Rank</th>
        <th>Seri</th>
       
    </tr>
    </thead>
    <tbody>
        <?php $i=1; ?>
    @foreach($starting_list as $row)
        <tr>
            <td>{{ $row->numbers }}</td>
      <td>{{ $row->nama_klub }}</td>
      <td>{{ $row->kota }}</td>
      <td>{{ $row->provinsi }}</td>
      <td>{{ $row->PIC }}</td>
      <td>{{ $row->phone_number }}</td>
      <td>{{ $row->nama_member }}</td>
      <td>{{ $row->gender }}</td>
      <td>{{ $row->tanggal_lahir }}</td>
      <td>{{ $row->tahun_lahir }}</td>
      <td>{{ $row->old_event_name }}</td>
      <td>{{ $row->old_race_name }}</td>
      <td>{{ $row->old_pure_race_name }}</td>
      <td>{{ $row->cur_event_name }}</td>
      <td>{{ $row->cur_event_start_date }}</td>
      <td>{{ $row->cur_event_end_date }}</td>
      <td>{{ $row->cur_race_name }}</td>
      <td>{{ $row->cur_pure_race_name }}</td>
      <td>{{ $row->seri }}</td>
      <td>{{ $row->line_number }}</td>
      <td>{{ timeFormat($row->time_result) }}</td>
      <td>{{ $row->rank_result }}</td>
      <td>{{ $row->payment_status }}</td>





        </tr>
    @endforeach
    </tbody>
</table>