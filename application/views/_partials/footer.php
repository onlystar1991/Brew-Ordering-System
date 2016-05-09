        </div>
    </div>
</div>
<!-- Scripts -->
<script type="text/javascript" src="<?= asset_base_url()?>/js/libs/chart.js/Chart.js"></script>
<script type="text/javascript" src="<?= asset_base_url()?>/js/dist/app.js"></script>

<?php 
	if (!isset($this->data['total_count'])) {
	?>
	<?php
	} else {
		$datas = $this->data['orders'];
		$jan = 0; $feb = 0; $mar = 0; $apr = 0; $may = 0; $jun = 0; $jul = 0; $aug = 0; $sep = 0; $oct = 0; $nov = 0; $dec = 0;
		foreach ($datas as $data) {
			$month_arr = explode("-", $data->order_date);
			$month = $month_arr[1];
			switch ($month) {
			    case "01":
			        $jan++;
			        break;
			    case "02":
			        $feb++;
			        break;
			    case "03":
			        $mar++;
			        break;
			    case "04":
			        $apr++;
			        break;
			    case "05":
			        $may++;
			        break;
			    case "06":
			        $jun++;
			        break;
			    case "07":
			        $jul++;
			        break;
			    case "08":
			        $aug++;
			        break;
			    case "09":
			        $sep++;
			        break;
			    case "10":
			        $oct++;
			        break;
			    case "11":
			        $nov++;
			        break;
			    case "12":
			        $dec++;
			        break;
			} 
		}
		?>
		<script>
			var buyers = document.getElementById('statCanvas1').getContext('2d');


			var buyerData = {
				labels : ["Jan","Feb","Mar","Apr","May","Jun","Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
				datasets : [
					{
						label: "Yearly",
                        fillColor : "transparent",
                        strokeColor : "#eb6101",
						data : [<?= $jan?>, <?= $feb?>, <?= $mar?>, <?= $apr?>, <?= $may?>, <?= $jun?>, <?= $jul?>, <?= $aug?>, <?= $sep?>, <?= $oct?>, <?= $nov?>, <?= $dec?>]
					}
				]
			}

    		new Chart(buyers).Line(buyerData);
		</script>


		<?php
	}
?>

<script type="text/javascript" src="<?= asset_base_url()?>/js/jquery-ui.js"></script>
</body>
</html>