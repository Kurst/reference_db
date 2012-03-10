<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<script type="text/javascript">
        var chart;


               $(document).ready(function() {


			var options = {
				chart: {
					renderTo: 'xchart',
					type: 'column'
				},
				title: {
					text: 'Статистика'
				},
				xAxis: {
					categories: []
				},
				yAxis: {
					title: {
						text: 'Количество'
					},
                                        allowDecimals:false
                                        
                                       
				},
				series: []
			};

			// Load the data from the XML file
			$.get(url+'user/home/get_chart_data', function(xml) {

				// Split the lines
				var $xml = $(xml);

				// push categories
				$xml.find('categories item').each(function(i, category) {
					options.xAxis.categories.push($(category).text());
				});

				// push series
				$xml.find('series').each(function(i, series) {
					var seriesOptions = {
						name: $(series).find('name').text(),
						data: []
					};

					// push data points
					$(series).find('data point').each(function(i, point) {
						seriesOptions.data.push(
							parseInt($(point).text())
						);
					});

					// add it to the options
					options.series.push(seriesOptions);
				});
				var chart = new Highcharts.Chart(options);
			});


		});





                

</script>
<p>
         

        <table width="480px" border="0" class="profile">

                <tr>
                        <td width="90px" rowspan="6" align="center" valign="top" style="padding:0px;"><?=html::anchor('user/profile/','<img src="'.url::base().'static/images/acl/avatars/'.$u_id.'/ava.png" />')?></td>
                        <td style="padding-left:15px;">
                                <table width="100%" border="0">
                                        <tr>

                                                <td width="70px"><b>Имя:</b></td>
                                                <td><?=$name?></td>
                                        </tr>
                                         <tr>

                                                <td ><b>Email:</b></td>
                                                <td><?=$author->email?></td>
                                        </tr>
                                        <tr>

                                                <td ><b>Возраст:</b></td>
                                                <td><?=$age?></td>
                                        </tr>
                                        <tr>

                                                <td ><b>Город:</b></td>
                                                <td><?=$author->city?></td>
                                        </tr>
                                      
                                        <tr>

                                                <td align="right" colspan="2"><?=html::anchor('user/profile/','Редактировать')?></td>
                                        </tr>
                                    </table>
                           </td>
                  </tr>
               
         </table>
<br/>
        <table width="480px" border="0" class="profile">

                <tr>
                        <th>События</th>
                       
                  </tr>
                  <tr  height="100px" valign="top">
                           <td style="padding-top: 10px; padding-left: 5px;">
                                   
                                   <table width ="100%">
                                           <?
                                                foreach($news as $n)
                                                {
                                                        echo "<tr>
                                                                <td>".html::anchor('user/news/id/'.$n->id,$n->title)." &nbsp; <span style='font-size: 0.7em; color:#ccc;'>// ".$n->date."</span></td>
                                                             </tr>";
                                                }
                                           ?>
                                   </table>
                           </td>
                  </tr>


         </table>
<br/>
        <!--<table width="480px" border="0" class="profile">

                <tr>
                        <th>Активность</th>

                  </tr>
                  <tr  height="100px" valign="top">
                           <td style="padding-top: 10px; padding-left: 5px;">

                                   <table width ="100%">
                                          
                                   </table>
                           </td>
                  </tr>


         </table>-->

<div id="xchart" style="width: 480px; height: 400px; "></div>
</p>


