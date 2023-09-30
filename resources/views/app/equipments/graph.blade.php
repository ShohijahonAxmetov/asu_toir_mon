<!DOCTYPE html>
<html>
<head>
	<title>Структура {{$equipment->garage_number}}</title>

	<!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="/assets/css/libs.bundle.css" />
    <link rel="stylesheet" href="/assets/css/theme.bundle.css" />
	<style>
		.node {
		    cursor: pointer;
		}
		.node circle {
		    fill: #fff;
		    stroke: steelblue;
		    stroke-width: 1.5px;
		}
		.node text {
		    font: 10px sans-serif;
		}
		.link {
		    fill: none;
		    stroke: #ccc;
		    stroke-width: 1.5px;
		}
        body {
            margin: 0;
        }
	</style>
</head>
<body>
	<!-- HEADER -->
    <div class="header">
        <div class="container-fluid">
		<div class="mt-3">
	        <a href="{{route('equipments.show', ['equipment' => $equipment])}}">< Назад</a>
	    </div>
            <!-- Body -->
            <div class="header-body">
                <div class="row align-items-end">
                    <div class="col">

                        <!-- Title -->
                        <h1 class="header-title">
                            Наработки оборудования {{$equipment->typeEquipment->name}} №{{$equipment->garage_number}}
                        </h1>

                    </div>
                    <div class="col-auto">

                    </div>
                </div> <!-- / .row -->
            </div> <!-- / .header-body -->
        </div>
    </div> <!-- / .header -->
	<div class="container-fluid">
        <div class="card mt-4">
            <div class="card-body">
                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Название</th>
                            <th scope="col">Наработки</th>
                            <th scope="col">Остаточный ресурс</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($uzels as $key => $item)
                            <tr>
                                <th scope="row" style="width: 100px">{{ $loop->iteration }}</th>
                                <td>
                                    <div class="d-flex align-items-center">
                                        {{ $item->technicalResource->catalog_name }}
                                    </div>
                                </td>
                                <td>{{ $item->technicalResource->catalog_name ?? '--' }}</td>
                                <td>{{ $item->technicalResource->catalog_name ?? '--' }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- HEADER -->
    <div class="header">
        <div class="container-fluid">

            <!-- Body -->
            <div class="header-body">
                <div class="row align-items-end">
                    <div class="col">

                        <!-- Title -->
                        <h1 class="header-title">
                            Структура оборудования {{$equipment->typeEquipment->name}} №{{$equipment->garage_number}}
                        </h1>

                    </div>
                    <div class="col-auto">

                    </div>
                </div> <!-- / .row -->
            </div> <!-- / .header-body -->
        </div>
    </div> <!-- / .header -->
	<div class="container-fluid">
		<div id="graph" class="w-100" style="height: 97vh"></div>
	</div>

	<script src="https://d3js.org/d3.v3.min.js"></script>
	<script type="text/javascript">
	    var margin = {
	        top: 20,
	        right: 120,
	        bottom: 20,
	        left: 120
	    },
	    width = 960 - margin.right - margin.left,
	    height = 800 - margin.top - margin.bottom;

	    var root = @json($graph);

	    var i = 0,
	        duration = 750,
	        // rectW = 100,
	        rectW = 100 / 5,
	        rectH = 30;

	    var tree = d3.layout.tree().nodeSize([120, 40]);
	    var diagonal = d3.svg.diagonal()
	        .projection(function (d) {
	        return [d.x + rectW / 2, d.y + rectH / 2];
	    });

	    var svg = d3.select("#graph").append("svg").attr("width", "100%").attr("height", "100%")
	        .call(zm = d3.behavior.zoom().scaleExtent([1,3]).on("zoom", redraw)).append("g")
	        .attr("transform", "translate(" + 350 + "," + 20 + ")");

	    //necessary so that zoom knows where to zoom and unzoom from
	    zm.translate([350, 20]);

	    root.x0 = 0;
	    root.y0 = height / 2;

	    function collapse(d) {
	        if (d.children) {
	            d._children = d.children;
	            d._children.forEach(collapse);
	            d.children = null;
	        }
	    }

	    root.children.forEach(collapse);
	    update(root);

	    d3.select("#graph");

	    function update(source) {

	        // Compute the new tree layout.
	        var nodes = tree.nodes(root).reverse(),
	            links = tree.links(nodes);

	        // Normalize for fixed-depth.
	        nodes.forEach(function (d) {
	            d.y = d.depth * 180;
	        });

	        // Update the nodes…
	        var node = svg.selectAll("g.node")
	            .data(nodes, function (d) {
	            return d.id || (d.id = ++i);
	        });

	        // Enter any new nodes at the parent's previous position.
	        var nodeEnter = node.enter().append("g")
	            .attr("class", "node")
	            .attr("transform", function (d) {
	            return "translate(" + source.x0 + "," + source.y0 + ")";
	        })
	            .on("click", click);

	        // nodeEnter.append("rect")
	        //     .attr("width", rectW)
	        //     .attr("height", rectH)
	        //     .attr("stroke", "black")
	        //     .attr("stroke-width", 1)
	        //     .style("fill", function (d) {
	        //     return d._children ? "lightsteelblue" : "#fff";
	        // });
	        nodeEnter.append("circle")
	            .attr("r", rectW)
	            // .attr("height", rectH)
	            .attr("stroke", "black")
	            .attr("stroke-width", 1)
	            .style("fill", function (d) {
	            return d._children ? "lightsteelblue" : "#fff";
	        });

	        // nodeEnter.append("text")
	        //     .attr("x", rectW / 2)
	        //     .attr("y", rectH / 2)
	        //     .attr("dy", ".35em")
	        //     .attr("text-anchor", "middle")
	        //     .text(function (d) {
	        //     return d.name;
	        // });
            nodeEnter.append("text")
	            .attr("x", 0)
	            .attr("y", 0)
	            .attr("dy", ".35em")
	            .attr("text-anchor", "middle")
	            .text(function (d) {
	            return d.name;
	        });

	        // Transition nodes to their new position.
	        var nodeUpdate = node.transition()
	            .duration(duration)
	            .attr("transform", function (d) {
	            return "translate(" + d.x + "," + d.y + ")";
	        });

	        // nodeUpdate.select("rect")
	        //     .attr("width", rectW)
	        //     .attr("height", rectH)
	        //     .attr("stroke", "black")
	        //     .attr("stroke-width", 1)
	        //     .style("fill", function (d) {
	        //     return d._children ? "lightsteelblue" : "#fff";
	        // });
            nodeUpdate.select("circle")
	            .attr("r", rectW)
	            // .attr("height", rectH)
	            .attr("stroke", "black")
	            .attr("stroke-width", 1)
	            .style("fill", function (d) {
	            return d._children ? "lightsteelblue" : "#fff";
	        });

	        nodeUpdate.select("text")
	            .style("fill-opacity", 1);

	        // Transition exiting nodes to the parent's new position.
	        var nodeExit = node.exit().transition()
	            .duration(duration)
	            .attr("transform", function (d) {
	            return "translate(" + source.x + "," + source.y + ")";
	        })
	            .remove();

	        // nodeExit.select("rect")
	        //     .attr("width", rectW)
	        //     .attr("height", rectH)
	        // 	//.attr("width", bbox.getBBox().width)""
	        // 	//.attr("height", bbox.getBBox().height)
	        // 	.attr("stroke", "black")
	        //     .attr("stroke-width", 1);
            nodeExit.select("circle")
	            .attr("r", rectW)
	            // .attr("height", rectH)
	        	//.attr("width", bbox.getBBox().width)""
	        	//.attr("height", bbox.getBBox().height)
	        	.attr("stroke", "black")
	            .attr("stroke-width", 1);

	        nodeExit.select("text");

	        // Update the links…
	        var link = svg.selectAll("path.link")
	            .data(links, function (d) {
	            return d.target.id;
	        });

	        // Enter any new links at the parent's previous position.
	        link.enter().insert("path", "g")
	            .attr("class", "link")
	            .attr("x", rectW / 2)
	            .attr("y", rectH / 2)
	            .attr("d", function (d) {
	            var o = {
	                x: source.x0,
	                y: source.y0
	            };
	            return diagonal({
	                source: o,
	                target: o
	            });
	        });

	        // Transition links to their new position.
	        link.transition()
	            .duration(duration)
	            .attr("d", diagonal);

	        // Transition exiting nodes to the parent's new position.
	        link.exit().transition()
	            .duration(duration)
	            .attr("d", function (d) {
	            var o = {
	                x: source.x,
	                y: source.y
	            };
	            return diagonal({
	                source: o,
	                target: o
	            });
	        })
	            .remove();

	        // Stash the old positions for transition.
	        nodes.forEach(function (d) {
	            d.x0 = d.x;
	            d.y0 = d.y;
	        });
	    }

	    // Toggle children on click.
	    function click(d) {
	        if (d.children) {
	            d._children = d.children;
	            d.children = null;
	        } else {
	            d.children = d._children;
	            d._children = null;
	        }
	        update(d);
	    }

	    //Redraw for zoom
	    function redraw() {
	      //console.log("here", d3.event.translate, d3.event.scale);
	      svg.attr("transform",
	          "translate(" + d3.event.translate + ")"
	          + " scale(" + d3.event.scale + ")");
	    }
	</script>
</body>
</html>
