var r = 960,
 2     format = d3.format(",d"),
 3     fill = d3.scale.category20c();
 4 
 5 var bubble = d3.layout.pack()
 6     .sort(null)
 7     .size([r, r])
 8     .padding(1.5);
 9 
10 var vis = d3.select("#chart").append("svg")
11     .attr("width", r)
12     .attr("height", r)
13     .attr("class", "bubble");
14 
15 d3.json("../data/flare.json", function(json) {
16   var node = vis.selectAll("g.node")
17       .data(bubble.nodes(classes(json))
18       .filter(function(d) { return !d.children; }))
19     .enter().append("g")
20       .attr("class", "node")
21       .attr("transform", function(d) { return "translate(" + d.x + "," + d.y + ")"; });
22 
23   node.append("title")
24       .text(function(d) { return d.className + ": " + format(d.value); });
25 
26   node.append("circle")
27       .attr("r", function(d) { return d.r; })
28       .style("fill", function(d) { return fill(d.packageName); });
29 
30   node.append("text")
31       .attr("text-anchor", "middle")
32       .attr("dy", ".3em")
33       .text(function(d) { return d.className.substring(0, d.r / 3); });
34 });
35 
36 // Returns a flattened hierarchy containing all leaf nodes under the root.
37 function classes(root) {
38   var classes = [];
39 
40   function recurse(name, node) {
41     if (node.children) node.children.forEach(function(child) { recurse(node.name, child); });
42     else classes.push({packageName: name, className: node.name, value: node.size});
43   }
44 
45   recurse(null, root);
46   return {children: classes};
47 }