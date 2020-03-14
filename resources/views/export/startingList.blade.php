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
        <th>Nomor Lomba</th>
        <th>Nama member</th>
        <th>Gender</th>
        <th>Nama Lomba</th>
        <th>Tahun Lahir</th>
        <th>Nama Club</th>
        <th>Kota</th>
        <th>Provinsi</th>
        <th>Best Time</th>

    </tr>
    </thead>
    <tbody>
        <?php $i=1; ?>
    @foreach($starting_list as $row)
        <tr>
            <td>{{ $i++}}</td>
            <td>{{ $row->race->race_number }}</td>
            <td>{{ $row->member->name }}</td>
            <td>{{ $row->member->gender }}</td>
            <td>{{ $row->race->pureRaces->name }}</td>
            <td>{{ date("Y", strtotime($row->member->born_date)) }}</td>
            <td>{{ $row->member->clubs->name }}</td>
            <td>{{ $row->member->clubs->city }}</td>
            <td>{{ $row->member->clubs->province }}</td>
            <td>{{ timeFormat( $row->old_best_time )}}</td>


        </tr>
    @endforeach
    </tbody>
</table> 