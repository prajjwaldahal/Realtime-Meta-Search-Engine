<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["query"])) {

	// Get the query from the form
$query = $_GET['query'];
       // Search Bing
	   $bing_url = "https://www.bing.com/search?q=" . urlencode($query);
	   $bing_results = file_get_contents($bing_url);
	   if (strpos($bing_results, 'We did not find results for') !== false) {
		   echo "Bing<br>No results found.<br>";
		   $bing_sorted_results = array();
	   } else {
		   // Remove any CSS or JavaScript from the Bing results
		   $bing_results = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', "", $bing_results);
		   $bing_results = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $bing_results);
		   // Get the search result links and titles from the Bing results
		   preg_match_all('/<a href="(.*?)".*?>(.*?)<\/a>/', $bing_results, $bing_matches);
		   $bing_links = $bing_matches[1];
		   $bing_titles = $bing_matches[2];
		   // Combine the search result links and titles into an array
		   $bing_combined_results = array_combine($bing_links,$bing_titles);
// Sort the combined search results by title
asort($bing_combined_results);
$bing_sorted_results = $bing_combined_results;
echo "<br><br><br>Bing<br>";
// Display the sorted search results
foreach ($bing_sorted_results as $link => $title) {
//$link = preg_replace('/^.?r=https?://localhost(/.)$/', '$1', $link);
$link = urldecode($link);
echo "<a href='$link'>$title</a><br>";
}
echo "<hr>";
}


// Google search engine URL
$google_url = "https://www.google.com/search?q=";

// Encode the query for use in the URL
$encoded_query = urlencode($query);

// Build the Google search URL with the encoded query
$search_url = $google_url . $encoded_query;

// Get the search results from Google
$google_sorted_results = file_get_contents($search_url);

// Remove CSS from the search results
$google_sorted_results = preg_replace('/<link\s.*?>/i', '', $google_sorted_results);
$google_sorted_results = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', '', $google_sorted_results);

// Remove local host prefix from the links
$google_sorted_results = str_replace('href="/', 'href="https://www.google.com/', $google_sorted_results);

// Display the combined and sorted search results
echo $google_sorted_results;


    // Search Yahoo
    $yahoo_url = "https://in.search.yahoo.com/search?p=" . urlencode($query);
    $yahoo_results = file_get_contents($yahoo_url);
    if (strpos($yahoo_results, 'No results found for') !== false) {
        echo "Yahoo<br>No results found.<br>";
        $yahoo_sorted_results = array();
    } else {
        // Remove any CSS or JavaScript from the Yahoo results
        $yahoo_results = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', "", $yahoo_results);
        $yahoo_results = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $yahoo_results);
        // Get the search result links and titles from the Yahoo results
        preg_match_all('/<a href="(.*?)".*?>(.*?)<\/a>/', $yahoo_results, $yahoo_matches);
        $yahoo_links = $yahoo_matches[1];
        $yahoo_titles = $yahoo_matches[2];
        // Combine the search result links and titles into an array
        $yahoo_combined_results = array_combine($yahoo_links, $yahoo_titles);
        // Sort the combined search results by title
        asort($yahoo_combined_results);
        $yahoo_sorted_results = $yahoo_combined_results;
        echo "<br><br><br>Yahoo<br>";
        // Display the sorted search results without the local host prefix
        foreach ($yahoo_sorted_results as $link => $title) {
          
            echo "<a href='$link'>$title</a><br>";
        }
        echo "<hr>";
    }
}
?>
