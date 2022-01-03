<?php
// $url = "https://raw.githubusercontent.com/owid/covid-19-data/master/public/data/vaccinations/vaccinations.json";
// $json = file_get_contents($url);
// $json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
// $obj = json_decode($json) ;
// $country= array();
// for($i=0;$i<=10;$i++){
//   $bc_id0 = $obj[$i]->iso_code;
//   array_push($country,$bc_id0);
// }


// https://github.com/owid/covid-19-data/tree/master/public/data

$url = "https://raw.githubusercontent.com/owid/covid-19-data/master/public/data/latest/owid-covid-latest.json";
$json = file_get_contents($url);
$json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');

$obj = json_decode($json) ;

$bc_id1 = $obj->{"OWID_WRL"}->last_updated_date;
$bc_id2 = $obj->{"OWID_WRL"}->new_deaths;
$bc_id3 = $obj->{"OWID_WRL"}->new_cases;

// https://github.com/owid/covid-19-data/blob/master/public/data/vaccinations/locations.csv
$country= [
    'OWID_WRL','DEU','USA','BRA','CAN','FRA','RUS',
    'JPN','ITA','CHN','IND','THA','SGP','MYS',
    'IDN','AUS','HKG','IND','BGD','KHM','CMR',
    'CHL','COL','CUB','CUB','EGY','EST','FIN','GEO','GHA',
    'GRC','HTI','HUN','ISL','IRN','IRQ','ISR','JAM','KEN','LAO',
    'MAC','MLT','MEX','MMR','NPL','NZL','NOR','PER','PAK','PAN',
    'PHL','POL','PRT','ROU','OWID_SCT','ZAF','KOR','ESP','SWE','CHE',
    'TWN','TUR','UGA','GBR','VNM'
  ];

$category= [
    'population',
    'total_cases',
    'new_deaths',
    'total_deaths_per_million',
    // 'new_vaccinations',
    'total_vaccinations',
    'people_vaccinated_per_hundred',
    'people_fully_vaccinated_per_hundred',
    'new_cases',
    'total_cases',
    'aged_65_older'
  ];

$id = $_GET["ad1"];
$category_2 = $category[$id];

// $title= [
//   '新規死亡者数','新規ワクチン接種数','新規感染者数'
// ];

$wld_name= array();
$wld_array= array();

$column6= array();
$column7= array();
$column8= array();
$column9= array();

$country_cnt = count($country)-1;
$category_cnt = count($category)-1;

for($i=0;$i<=$country_cnt;$i++){
// $bc_id5 = $obj->{"$country[$i]"}->new_deaths;
// $bc_id5 = $obj->{"$country[$i]"}->$category[$id];
$bc_id4 = $obj->{"$country[$i]"}->location;
$bc_id5 = $obj->{"$country[$i]"}->$category_2;
array_push($wld_name,$bc_id4);
array_push($wld_array,$bc_id5);

// $fruits = array();
// $field = [$bc_id4];
// foreach( $field as $key ){ 
//   $fruits[] = $bc_id4;
// }

$bc_id6 = $obj->{"$country[$i]"}->population;
$bc_id7 = $obj->{"$country[$i]"}->new_deaths;
$bc_id8 = $obj->{"$country[$i]"}->new_cases;
$bc_id9 = $obj->{"$country[$i]"}->aged_65_older;

array_push($column6,$bc_id6);
array_push($column7,$bc_id7);
array_push($column8,$bc_id8);
array_push($column9,$bc_id9);

}



for ( $ii = 0; $ii <= $category_cnt; $ii++) {
  $week0 .= '<option value = "';
  $week0 .= $ii;
  $week0 .= '">';
  // $week0 .= $title[$ii];
  $week0 .= $category[$ii];
  $week0 .= '</option>';
    }
    

$country_array = array();
$country_rank_array = array();

for ( $i = 0; $i <= $country_cnt; $i++) {

 $country_list ='["'.$wld_name[$i].'", "'.$wld_name[$i].':'.$wld_array[$i].'"],';

 $country_rank = '<th scope="row">'.$wld_name[$i].'</th>
 <th scope="row">'.$column6[$i].'</th>
 <td>'.$column7[$i].'</td>
 <td>'.$column8[$i].'</td>
 <td>'.$column9[$i].'</td></tr>';

 array_push($country_array,$country_list);
 array_push($country_rank_array,$country_rank);
}

$test = implode($country_array);
$test2 = implode($country_rank_array);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COVID19 API</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container p-3 my-3">
        <div id="app">
            <div class="d-flex justify-content-center">
                <h3>COVID19国別感染者数</h3>
            </div>
            <div class="d-flex justify-content-center py-3">
                <h5>全世界 <?=$bc_id1?>
                    </br>新規死者数：<?=$bc_id2?>
                    </br>新規感染者数：<?=$bc_id3?>
                </h5>
            </div>
            <div class="d-flex justify-content-center">
                  <form action="index.php" method="get">
                    </br>
                    <select name= "ad1">
                    <?=$week0?></br>
                    </select>
                    <input class="" type="submit" value="入力する">
                </form>
                </div>
         </div>

      </div>

    <section>
    <!-- <p>地図：<?=$title[$id]?></p> -->
    <p>地図：<?=$category[$id]?></p>
    <div class="d-flex justify-content-center py-3" id="regions_div" style="width: 100%; height: 100%;"></div>
    </section>

    <section class="d-flex justify-content-center py-3">
    <div class="container">
        <table class="table">
          <thead class="thead-light">
              <tr><th scope="col">国</th>
              <th scope="col">人口</th>
              <th scope="col">新規コロナ死者数</th>
              <th scope="col">新規ワクチン数</th>
              <th scope="col">65歳以上人口(%)</th></tr>
            </thead><tbody>
            <tr>

            <?=$test2?>

        </tbody></table>
    </div>
    </section>
    
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {
        'packages':['geochart'],
      });
      google.charts.setOnLoadCallback(drawRegionsMap);

      function drawRegionsMap() {
      
        var data = google.visualization.arrayToDataTable([
          // https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2#DZ
          ['Country', 'Popularity'],
          <?php echo $country_array[0] ?>
          <?php echo $test ?>
          ['Country', 'Popularity']
        ]);

        var options = {};

        var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));

        chart.draw(data, options);
      }

    </script>
</body>