<?php
require_once('DatumboxAPI.php');

$api_key='00385983467582389dfa576a96736a52'; //To get your API visit datumbox.com, register for an account and go to your API Key panel: http://www.datumbox.com/apikeys/view/

$DatumboxAPI = new DatumboxAPI($api_key);

//Example of using Document Classification API Functions
$text = $_GET['text'];

$DocumentClassification=array();
$DocumentClassification['AdultContentDetection']=$DatumboxAPI->AdultContentDetection($text);
$DocumentClassification['SentimentAnalysis']=$DatumboxAPI->SentimentAnalysis($text);
$DocumentClassification['SubjectivityAnalysis']=$DatumboxAPI->SubjectivityAnalysis($text);
$DocumentClassification['SpamDetection']=$DatumboxAPI->SpamDetection($text);
$DocumentClassification['ReadabilityAssessment']=$DatumboxAPI->ReadabilityAssessment($text);

unset($DatumboxAPI);

return header("Location: ../tools/feedback/actions/content-checker?feedback_id=" . $_GET['feedback_id'] . "&adult=" . $DocumentClassification['AdultContentDetection'] . "&sentiment=" . $DocumentClassification['SentimentAnalysis'] . "&subjectivity=" . $DocumentClassification['SubjectivityAnalysis'] . "&spam=" . $DocumentClassification['SpamDetection'] . "&readability=" . $DocumentClassification['ReadabilityAssessment']);
