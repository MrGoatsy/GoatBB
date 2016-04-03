<h3>Welcome to the control panel <span style="color: rgb(16, 145, 0);"><?php echo $_SESSION[$uniqueCode]; ?></span></h3>
<div class="row flex">
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <li class="fa fa-fw fa-users"></li>
                    User registrations
                </h4>
            </div>
            <div class="panel-body">
                <canvas id="users"></canvas>
            </div>
        </div>
        <script>
            var barChartData = {
                labels : ["January","February","March","April","May","June","July","August","September","October","November","December"],
                datasets : [
                    {
                        fillColor : "rgba(220,220,220,0.5)",
        				strokeColor : "rgba(220,220,220,0.8)",
        				highlightFill: "rgba(220,220,220,0.75)",
        				highlightStroke: "rgba(220,220,220,1)",
                        data : <?php echo userMonth(); ?>
                    }
                ]
            };
        </script>
    </div>
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <li class="fa fa-fw fa-envelope-o"></li>
                    Most popular sections
                </h4>
            </div>
            <div class="panel-body">
                <canvas id="section"></canvas>
            </div>
        </div>
        <script>
            var sectionBarData = {
                labels : <?php echo getallsections(); ?>,
                datasets : [
                    {
                        fillColor : "rgba(220,220,220,0.5)",
                        strokeColor : "rgba(220,220,220,0.8)",
                        highlightFill: "rgba(220,220,220,0.75)",
                        highlightStroke: "rgba(220,220,220,1)",
                        data : <?php echo getsections(); ?>
                    }
                ]
            };

        	window.onload = function(){
                var ctx = document.getElementById("users").getContext("2d");
        		window.myBar = new Chart(ctx).Bar(barChartData, {
        			responsive : true
        		});

                var section = document.getElementById("section").getContext("2d");
        		window.myBar = new Chart(section).Bar(sectionBarData, {
        			responsive : true
        		});
        	};
    	</script>
    </div>
    <div class="col-md-3">
    </div>
    <div class="col-md-3">
    </div>
</div>
