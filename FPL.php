<!DOCTYPE html>
<html>
<head>
<style>

#player_info {
	font: "Arial";
	border-collapse: collapse;
	width: 100%;
}

#player_info td, #player_info th {
 	border: 1px solid #ddd;
 	padding: 5px;
}

#player_info tr:nth-child(even) {
	background-color: #f2f2f2;
}

#player_info tr:hover {
	background-color: #ddd;
}

#player_info th {
	padding-top: 12px;
	padding-bottom: 12px;
	text-align: left;
	background-color: #242424;
	color: white;
}

</style>
</head>

<?php
// Retrieve info from our API using cURL
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://fantasy.premierleague.com/api/bootstrap-static/",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache"
  ),
));

$fplAPI = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);

$data = json_decode($fplAPI, true);
?>

<button onclick="doCSV()"">Export HTML Table To CSV File</button>

<!--Fill first table row with our headings for our data -->
<table id ="player_info">
<tr>
 <th>ID</th>
 <th>FPL Name</th>
 <th>Player ID</th>
 <th>Full Name</th>
 <th>Team</th>
 <th>Availability</th>
 <th>Position</th>
 <th>Current Price</th>
 <th>Value Season</th>
 <th>Cost Change from Start</th>
 <th>Percentage Selected By</th>
 <th>Transfers In</th>
 <th>Transfers Out</th>
 <th>Total Points</th> 
 <th>Points Per Game</th>
 <th>Minutes</th>
 <th>Goals Scored</th>
 <th>Assists</th>
 <th>Clean Sheets</th>
 <th>Goals Conceded</th>
 <th>Own Goals</th>
 <th>Penalties Saved</th>
 <th>Penalties Missed</th>
 <th>Yellow Cards</th>
 <th>Red Cards</th>
 <th>Saves</th>
 <th>Bonus Points</th>
 <th>Bonus Point System Score</th>
 <th>Influence</th>
 <th>Creativity</th>
 <th>Threat</th> 
 <th>ICT Index</th>
</tr>

<?php
// Loop through all of our data and add it into our table
foreach($data['elements'] as $key=>$item)
{
	?>
	<tr>
        <td><?PHP echo $item['id']; ?></td>
        <td><?PHP echo $item['web_name']; ?></td>
        <td><?PHP echo $item['code']; ?></td>
        <td><?PHP echo $item['first_name']; ?> <?PHP echo $item['second_name']; ?></td>
		<td><?PHP switch ($item['team_code']){
			case 3: echo 'Arsenal';
			break;
			case 7: echo 'Aston Villa';
			break;
			case 91: echo 'Bournemouth';
			break;
			case 36: echo 'Brighton';
			break;
			case 90: echo 'Burnley';
			break;
			case 8: echo 'Chelsea';
			break;
			case 31: echo 'Crystal Palace';
			break;
			case 11: echo 'Everton';
			break;
			case 13: echo 'Leicester';
			break;
			case 14: echo 'Liverpool';
			break;
			case 43: echo 'Man City';
			break;
			case 1: echo 'Man Utd';
			break;
			case 4: echo 'Newcastle';
			break;
			case 45: echo 'Norwich City';
			break;
			case 49: echo 'Sheffield United';
			break;
			case 20: echo 'Southamptom';
			break;
			case 6: echo 'Tottenham Hotspur';
			break;
			case 57: echo 'Watford';
			break;
			case 21: echo 'West Ham United';
			break;
			case 39: echo 'Wolverhampton Wanderers';
			break;
			} ?></td>
		<td><?PHP if ($item['news'] == null) {echo 'Available';} else {echo $item['news'];}?></td>
        <td><?PHP echo $item['element_type']; ?></td>
        <td><?PHP echo $item['now_cost']; ?></td>
        <td><?PHP echo $item['value_season']; ?></td>
        <td><?PHP echo $item['cost_change_start']; ?></td>
        <td><?PHP echo $item['selected_by_percent']; ?></td>
        <td><?PHP echo $item['transfers_in']; ?></td>
        <td><?PHP echo $item['transfers_out']; ?></td>
        <td><?PHP echo $item['total_points']; ?></td>
        <td><?PHP echo $item['points_per_game']; ?></td>
        <td><?PHP echo $item['minutes']; ?></td>
        <td><?PHP echo $item['goals_scored']; ?></td>
        <td><?PHP echo $item['assists']; ?></td>
        <td><?PHP echo $item['clean_sheets']; ?></td>
        <td><?PHP echo $item['goals_conceded']; ?></td>
        <td><?PHP echo $item['own_goals']; ?></td>
        <td><?PHP echo $item['penalties_saved']; ?></td>
        <td><?PHP echo $item['penalties_missed']; ?></td>
        <td><?PHP echo $item['yellow_cards']; ?></td>
        <td><?PHP echo $item['red_cards']; ?></td>
        <td><?PHP echo $item['saves']; ?></td>
        <td><?PHP echo $item['bonus']; ?></td>
        <td><?PHP echo $item['bps']; ?></td>
        <td><?PHP echo $item['influence']; ?></td>
        <td><?PHP echo $item['creativity']; ?></td>
        <td><?PHP echo $item['threat']; ?></td>
        <td><?PHP echo $item['ict_index']; ?></td>
    </tr>
    <?php
}
?>
</table>

<script>function doCSV()
{
	var table = document.getElementById("player_info").innerHTML;
	var data = table.replace(/<thead>/g, '')
		.replace(/<\/thead>/g, '')
		.replace(/<tbody>/g, '')
		.replace(/<\/tbody>/g, '')
		.replace(/<tr>/g, '')
		.replace(/<\/tr>/g, '\r\n')
		.replace(/<th>/g, '')
		.replace(/<\/th>/g, ',')
		.replace(/<td>/g, '')
		.replace(/<\/td>/g, ',')
		.replace(/\t/g, '')
		.replace(/\n/g, '');
    var link = document.createElement('a');
    link.download = "fplinfo.csv";
    link.href = "data:application/csv," + escape(data);
	link.click();
	
}</script>