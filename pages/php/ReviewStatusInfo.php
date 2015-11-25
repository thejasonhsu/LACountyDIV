<?php
	function getStatusView($ain) {
		$year = date( "Y" );
		$year = intval( $year );
		$month = date( "n" );
		$month = intval( $month );
		$CurrentRollYYYY;
		if ( $month < 7 ) {
			$CurrentRollYYYY = $year - 1;
		}
		else {
			$CurrentRollYYYY = $year;
		}
		$RollPrepYYYY = $CurrentRollYYYY + 1;

		$dbResults = getStatusParcel($ain);

		if ( empty( $dbResults ) ) {
			return "Error";
		}

		$informationString = "";

		if ( $dbResults['isOtherValuation'] == 'Y' ) {
			$informationString = 	"<p id=\"no-result-text\" style=\"display:block\">
										The results of your " . $dbResults['RollYYYY'] . " decline-in-value review cannot be displayed due to recent assessment activity. The following are examples of recent assessment activities that would affect your decline-in-value:
									</p>
									<div id=\"assessment-activities\" style=\"display:none; width:50%; margin:auto\">
										<ul>
											<li>
												Reappraisable new construction
											</li>
											<li>
												Subsequent change in ownership
											</li>
											<li>
												Parcel subdivision or combine
											</li>
											<li>
												Prior year value correction
											</li>
										</ul>
									</div>";
		}
		else if ( intval( $dbResults['RollYYYY'] ) == $RollPrepYYYY ) {
			if ( $dbResults['isProp8Restoration'] == 'Y' || $dbResults['isProactiveProp8'] == 'Y' || $dbResults['statusApplication'] == 'C' || $dbResults['statusApplication'] == 'X' || $dbResults['statusRequestReview'] == 'C' || $dbResults['statusRequestReview'] == 'X' ) {
				$informationString = "<p id=\"assessment-text\">
										We will review your property for a <span>" . $dbResults['RollYYYY'] . "</span> decline-in-value to reflect the lower of its market value or Proposition 13 Value as of <span>January 1, " . $dbResults['RollYYYY'] . "</span>. Your <span>" . $dbResults['RollYYYY'] . "-" . (intval( $dbResults['RollYYYY'] ) + 1) . "</span> annual taxes will be based on the results of that review. Those results will be available online here in August <span>" . $dbResults['RollYYYY'] . "</span>. (<a href=\"http://assessor.co.la.ca.us/extranet/list/faqList.aspx?faqID=86\">What is a Proposition 13 Value?</a>)
									 </p>";
			}
			else {
				$informationString = "<p id=\"disqualified-text\" style=\"display:block\">
										Your property does not automatically qualify for a " . $dbResults['RollYYYY'] . " decline-in-value review.
									 </p>";
			}
		}
		else if ( intval( $dbResults['RollYYYY'] ) == $CurrentRollYYYY && $dbResults['Prop8_LandValue'] != null ) {
			$informationString = 	"<p id=\"assessment-text\">
										We will review your property for a <span>" . $dbResults['RollYYYY'] . "</span> decline-in-value to reflect the lower of its market value or Proposition 13 Value as of <span>January 1, " . $dbResults['RollYYYY'] . "</span>. Your <span>" . $dbResults['RollYYYY'] . "-" . (intval( $dbResults['RollYYYY'] ) + 1) . "</span> annual taxes will be based on the results of that review. Those results will be available online here in August <span>" . $dbResults['RollYYYY'] . "</span>. (<a href=\"http://assessor.co.la.ca.us/extranet/list/faqList.aspx?faqID=86\">What is a Proposition 13 Value?</a>)
									</p>
									<div id=\"property-value\" style=\"display:block;\">
										<p>The following values reflect the results of our " . $dbResults['RollYYYY'] . " review of your property:</p>
										<div style=\"width:50%; margin:auto\">
											<div style=\"text-align:center\">Value on January 1, " . $dbResults['RollYYYY'] . "</div>
											<div style=\"display:inline-block; float:left\">
												Land:<br/>
												Improvements:<br/>
												Total Real Property:<br/>
												Exemption:<br/>
												Taxable Value:
											</div>
											<div style=\"text-align:right; float:right\">
												$" . $dbResults['Prop8_LandValue'] . "<br/>
												$" . $dbResults['Prop8_ImpValue'] . "<br/>
												$" . ( intval( $dbResults['Prop8_LandValue'] ) + intval( $dbResults['Prop8_ImpValue'] ) ) . "<br/>
												$" . $dbResults['Prop8_ExemptionAmount'] . "<br/>
												$" . $dbResults['OnlineFiling_projectedLandImpValue'] . "
											</div>
											<div style=\"clear:both\"></div>
										</div>
										<p><strong>Your " . $dbResults['RollYYYY'] . "-" . (intval( $dbResults['RollYYYY'] ) + 1) . " annual taxes (covering July 1, " . $dbResults['RollYYYY'] . " through June 30, " . (intval( $dbResults['RollYYYY'] ) + 1) . ") are currently based on the above values. Annual tax bills are mailed in October.</strong></p>
									</div>";
		}

		return $informationString;
	}

	function getStatusParcel($ain) {
		$connection = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
		$sql = "SELECT * FROM " . DIV_PARCEL_STATUS_TABLE . " WHERE AIN = :ain";
		$statement = $connection->prepare( $sql );
		$statement->bindValue( ":ain", $ain, PDO::PARAM_INT );
		$success = $statement->execute();
		$dbResults = array();
		$dbResults = $statement->fetch();
		$connection = null;

		return $dbResults;
	}
?>