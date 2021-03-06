<?php defined( 'ABSPATH' ) or die(); ?>

<script type="text/javascript">
	jQuery(document).ready(function ($) {
		<?php if( ! is_array( $statical_data ) || empty( $statical_data ) ) { ?>
		$('#metrica-graph').html("<p><?php _e('Sorry, couldn\'t draw graph for selected period, please try different time period.','yandex-metrica');?></p>");
		<?php } else { ?>
		$('#metrica-graph').highcharts({
			chart   : {
				type: 'line'
			},
			title   : {
				text: '<?php echo __('Metrica Traffic','yandex-metrica');?>'
			},
			credits : {
				enabled: false
			},
			subtitle: {
				text: '<?php echo __('Source','yandex-metrica');?>:<?php echo self::$metrica_api->get_counter_name( $this->options["counter_id"] );?>'
			},
			xAxis   : {
				type      : 'datetime',
				categories: [
					<?php
					// use WordPress' date function date_i18n instead of the php's date. Because localization matters...
					$date_format = ( $this->period != "monthly" ? 'D' : 'd M' );
					foreach(  $statical_data as $date => $stats_item ){
						echo "'" .date_i18n($date_format, strtotime( $date ) ). "',";
					}

					?>
				]

			},
			yAxis   : {
				title: {
					text: '<?php echo __('Visits','yandex-metrica');?>'
				},
				min  : 0
			},
			tooltip : {

				formatter: function () {
					return '<b>' + this.series.name + '</b><br/>' +
							this.x + ': ' + this.y;
				}
			},

			series: [
				{
					name: '<?php echo __('Pageviews','yandex-metrica');?>',
					data: [
						<?php foreach( $statical_data as $item){
							 echo $item["pageviews"].",";
						 };?>
					]
				},
				{
					name: '<?php echo __('Visits','yandex-metrica');?>',
					data: [
						<?php foreach( $statical_data as $item){
							 echo $item["visits"].",";
						 };?>
					]
				},
				{
					name: '<?php echo __('Unique','yandex-metrica');?>',
					data: [
						<?php foreach( $statical_data as $item){
							 echo $item["visitors"].',';
						};?>
					]
				}
			]
		});

		$("#toggle-metrica-popular-pages").click(function () {
			$(".metrica-popular-pages").toggle();
		});

		$("#toggle-metrica-top-referrers").click(function () {
			$(".metrica-top-referrers").toggle();
		});

		$("#toggle-metrica-top-searches").click(function () {
			$(".metrica-top-searches").toggle();
		});

		<?php } ?>

    });

</script>