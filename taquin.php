<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Taquin Puzzle | Kevin Shirley</title>
	<!-- <link rel="stylesheet" type="text/css" href="taquin.css"> -->
	<style type="text/css">
		/*
		======================== Style ========================
		*/

		/*
		========== General ==========
		*/

		* {
		    font-family: arial;
		}

		html, body {
		    top: 0;
		    bottom: 0;
		    margin: 0;
		    padding: 0;
		    box-sizing: border-box; 
		}

		.fullContainer {
		    top: 0;
		    left: 0;
		    bottom: 0;
		    margin: 0;
		    width: 100%;
		    height: auto;
		    display: flex;
		    flex-direction: column;
		    align-items: center;
		}


		/*
		========== Main ==========
		*/

		h1 {
		    -webkit-margin-after: 0em;
		    color: #313131;
		    font-size: 3.3em;
		    /*margin-bottom: 30px;*/
		}

		table {
		    margin-top: 50px;
		}

		#main {
		    margin: 0;
		    width: 440px;
		    height: 440px;
		    border: 1px solid #000;
		    display: flex;
		    justify-content: space-between;
		    column-count: 4;
		}

		.caseVide {
		    opacity: 0;
		}

		.uneCase {
		    border-radius: 15px;
		    height: 110px;
		    width: 110px;
		    cursor: pointer;
		    text-align: center;
		    color: #fff;
		    font-size: 5em;
		    transition: .2s;
		    z-index: 100;
		    outline: none;
		    /****** Background Gradients ******/
		    background: rgba(122,160,255,1);
		    background: -moz-radial-gradient(center, ellipse cover, rgba(122,160,255,1) 0%, rgba(173,188,255,1) 19%, rgba(200,220,234,1) 45%, rgba(34,158,241,1) 70%, rgba(57,123,198,1) 100%);
		    background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(0%, rgba(122,160,255,1)), color-stop(19%, rgba(173,188,255,1)), color-stop(45%, rgba(200,220,234,1)), color-stop(70%, rgba(34,158,241,1)), color-stop(100%, rgba(57,123,198,1)));
		    background: -webkit-radial-gradient(center, ellipse cover, rgba(122,160,255,1) 0%, rgba(173,188,255,1) 19%, rgba(200,220,234,1) 45%, rgba(34,158,241,1) 70%, rgba(57,123,198,1) 100%);
		    background: -o-radial-gradient(center, ellipse cover, rgba(122,160,255,1) 0%, rgba(173,188,255,1) 19%, rgba(200,220,234,1) 45%, rgba(34,158,241,1) 70%, rgba(57,123,198,1) 100%);
		    background: -ms-radial-gradient(center, ellipse cover, rgba(122,160,255,1) 0%, rgba(173,188,255,1) 19%, rgba(200,220,234,1) 45%, rgba(34,158,241,1) 70%, rgba(57,123,198,1) 100%);
		    background: radial-gradient(ellipse at center, rgba(122,160,255,1) 0%, rgba(173,188,255,1) 19%, rgba(200,220,234,1) 45%, rgba(34,158,241,1) 70%, rgba(57,123,198,1) 100%);
		    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#7aa0ff', endColorstr='#397bc6', GradientType=1 );
		}

		.uneCase:hover {
		    z-index: 101;
		    -webkit-box-shadow: 10px 10px 137px -19px rgba(0,0,0,0.75);
		    -moz-box-shadow: 10px 10px 137px -19px rgba(0,0,0,0.75);
		    box-shadow: 10px 10px 137px -19px rgba(0,0,0,0.75);
		}
	</style>
</head>
<body onload="preparerTableRow()">
	
	<div class="fullContainer container-fluid">
		
		<h1>Taquin Puzzle</h1>
		
		<div id="tableContainer">
			
		</div>

		<p>&copy; 2017 <a href="http://kevinshirley.com">Kevin Shirley</a>, All rights reserved.</p>

	</div>

<!-- <script src="taquin.js"></script> -->
<script type="text/javascript">
	console.log('========== Taquin Puzzle ==========');

	// tableau avec la postition des cases en memoire
	var cases = [
		[],
		[],
		[],
		[]
	];

	//generer un chiffre random
	var tabNumero = [];
	function randomNumber() {
		var numRand = Math.floor(Math.random() * 15 + 1);
		while ( tabNumero.indexOf(numRand) >= 0 ) {
			numRand = Math.floor(Math.random() * 15 + 1);
		}
		tabNumero.push(numRand);
		return numRand;
	}

	// position depart de la case vide
	var vide = {"row": 3, "col": 3};

	// position dans le tableau de memoire
	function position(num) {

		for (var i=0;i<4;i++) {
			for (var j=0;j<4;j++) {
				if ( cases[i][j]==num) {
				   return {"row": i, "col": j};
				}
			}
		}
		
	}

	// transferer les valeurs: changement de valeur
	function changement(num,position) {

		//	position des cases
		var caseRow = position.row;
		var caseCol = position.col;
		var videRow = vide.row;
		var videCol = vide.col;
		var caseValue = document.getElementById("maTable").rows[caseRow].cells[caseCol].innerHTML;

		// transferer les valeurs
		cases[caseRow][caseCol] = 0;
		cases[vide.row][vide.col] = num;
		vide.row = caseRow;
		vide.col = caseCol;

		// affecter le nouveau html
		document.getElementById("maTable").rows[vide.row].cells[vide.col].innerHTML = '';
		document.getElementById("maTable").rows[videRow].cells[videCol].innerHTML = caseValue;
		
	}

	function deplacement(button) {
		// valeur du button(this)
		var numValue = button.getAttribute('value');

		// emplacement de cette valeur dans le tableau en memoire
		var oCaseMemoire = position(numValue);

		// si les valeurs i,j correspondent, faire les changements de valeur
		if ( oCaseMemoire.col == vide.col) {
			if (Math.abs(oCaseMemoire.row-vide.row) == 1) {
				changement(numValue,oCaseMemoire);
			}
		} else {
			if ( oCaseMemoire.row == vide.row) {
				if (Math.abs(oCaseMemoire.col-vide.col) == 1) {
					changement(numValue,oCaseMemoire);
				}
			}
		}
	}


	function preparerTableRow() {

		var max = 0; // nb de case maximum
		var table = '<table id="maTable">';
		for (var i = 0; i < 4; i++) {
			table +='<tr>';
			for (var j = 0; j < 4; j++) {
				if (max < 15) {
					max++;
					var numRandom = randomNumber();
					table +='<td><button onClick="deplacement(this)" value='+numRandom+' class="uneCase">'+numRandom+'</button></td>';

					cases[i][j] = numRandom;
				} else {
					table += '<td>&nbsp;</td>';
				}
			}
			table += '</tr>';
		}
		table +='</table>';

		// affecter table creer dans le html
		document.getElementById('tableContainer').innerHTML = table;

	}

</script>
</body>
</html>