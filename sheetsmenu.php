<?

$sheets = new Sheets();
$sheets->setkeys(
	$sheet_id ='1dBnukgGOpHtTcjqZJ_cfLKQj8n5recdOUn4MYuoypVE', 
	$api_key='AIzaSyC4fWHy1MG1UDQuvOlIzuHg65XgRWMUUvs'
	);

$sheets->getdata();

// Build the html menus
$allsheets = $sheets->numberof();

for ($i=0; $i < $allsheets; $i++) { // multiple menus
	$data = $sheets->data($i); 
	$title = $sheets->title($i);
		
		$table = "<div class='food_table'>";
		$table .= "<div class='food_title'><h2>" . $title . '</h2></div>';
		foreach ($data as $content) {
			$table .="
				<div class='food_item'>";
			$table .= "
				<div class='food_diet'>
					$content[diet]
				</div>
				<div class='food_name'>
					$content[dish]
				</div>
				<div class='food_cost'>
					$content[cost]
				</div>";
			$table .= "
				</div><!-- /.item -->";
			$table .= "
				<div class='food_desc'>
					$content[desc]
				</div> ";
		}

		$table .='</div>';

		echo $table;
} // 


class Sheets {
	function getdata(){
		// Import the content from Google Sheets and puts the useful stuff into a nice array

		$url_info = 'https://sheets.googleapis.com/v4/spreadsheets/' . $this->sheet_id .'?key=' . $this->api_key; // get info about the spreadsheet

		$info = self::curlit($url_info); // send the url to the API, via the curl function (defined below), and get what it sends back

		$info = json_decode($info, true); // convert sheets into JSON format so it's easier to access

		$worksheets = $info['sheets'];
		$this->amount = count($worksheets);
			
		$count = 0;
		foreach ($worksheets as $sheet) {
			$sheet_title = ($sheet['properties']['title']); // Get actual name of worksheet as set in Google sheets.

			$url_data ='https://sheets.googleapis.com/v4/spreadsheets/'.$this->sheet_id.'/values/'.$sheet_title.'!A1:Z1000?key='.$this->api_key; // Get the spreadsheet content specified in fields A1 to Z1000. You could change this to the actual size of your spreadsheet. Empty rows and columns are omitted though. 
			$data = self::curlit($url_data); 

			$data = json_decode($data, true);

			// Make dish section into keyed array for ease of use
			foreach ($data['values'] as $dishes) {
				$keys = array('dish', 'desc', 'diet', 'cost');
				$keyarray = array_combine($keys, $dishes);
				$updata[] = $keyarray; 
			}

			$this->sheet[$count]['title'] = $sheet_title;
			$this->sheet[$count]['data'] = $updata;
			$updata = array(); // empty the array
			$count ++;
		}
			
	} // getdata()

	function setkeys($id,$api){
	// Pass the key and api keys needed for the API

		$this->sheet_id = $id;
		$this->api_key = $api;
	}
	
	function numberof(){
	// return number of worksheets
		return $this->amount;
	}

	function title($x){
	// return title for specific worksheet
		return $this->sheet[$x]['title'];
	}

	function data($x){
	// return data for specific worksheet
		return $this->sheet[$x]['data'];
			}

	function curlit($url){
	// Generalised data fetcher from $url

		$ch = curl_init($url); // such as http://example.com/example.xml
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	} // curlit
} // Sheets
?>