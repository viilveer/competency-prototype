$(document).ready(function () {
    var container = $('#tree');
    var graphContainer = $('#2dgraph');

    var options = {
        layout: {
            hierarchical: {
                direction: 'UD',
                nodeSpacing: 150
            }
        },
        nodes: {
            shape: 'box',
            margin: 10
        },
        physics: {
            enabled: false
        }
    };
    var network = new vis.Network(container.get(0), {}, options);
    var graphOptions = {
        legend: true,
        start: '2018-04-04',
        end: '2018-04-14'
    };
    var graph = new vis.Graph2d(graphContainer.get(0), {}, graphOptions);

    $(document).on('keyup', 'input.form-control', function () {
        var skillLevel = $(this).val();
        $.post($(this).parents('tr').data('update'), { skillLevel }, function (data) {
            setVisJsData();
        });

        return false;
    });

    /**
     * Reducer helper to get flatted items from tree
     * @param flatted
     * @param a
     * @returns {*}
     */
    function flat(flatted, a) {
        flatted.push(a);
        if (Array.isArray(a.children)) {
            return a.children.reduce(flat, flatted);
        }
        return flatted;
    }

    function getEdges(node, edges, parentNode) {
        var currentNode = node;

        if (parentNode) {
            edges.push({from: parentNode.id, to: currentNode.id});
        }

        currentNode.children.forEach(function (item) {
            edges = getEdges(item, edges, currentNode);
        });
        return edges;
    }

    function getColor(level) {
        var lightness = 30;
        if (level > 30) {
            lightness = level;
        }
        return ["hsl(120,100%,"+ lightness +"%)"].join("");
    }

    function getSmallestDate(items)
    {
        var smallestDate = items.reduce(function(prev, curr) {
            console.log(prev, curr);
            var smallerDate = curr.x;
            if (prev) {
                smallerDate = new Date(prev.x) > new Date(curr.x) ? curr : prev;
            }
            return smallerDate;
        });
        console.log(smallestDate);
        return smallestDate;
    }


    function setVisJsData() {
        $.getJSON(graphContainer.data('remote-url'), function (employeeSkills) {
            var groups = new vis.DataSet();
            for (var key in employeeSkills) {
                var skillGroups = employeeSkills[key].map(function (item) {
                    return {
                        id: item.skill_id,
                        content: item.skill.name
                    };
                });
                groups.add(skillGroups[0]);
            }
            var items = [];
            for (var key in employeeSkills) {
                var data = employeeSkills[key].map(function (item) {
                    return {
                        x: item.skill_date,
                        y: item.level,
                        group: parseInt(key)
                    };
                });
                items = items.concat(data);
            }
            var dataset = new vis.DataSet(items);
            var graphOptions = {
                start: getSmallestDate(items).x,
                end: new Date().toString()
            };

            graph.setGroups(groups);
            graph.setItems(dataset);
            graph.setOptions(graphOptions);
            graph.redraw();
        });
        $.getJSON(container.data('remote-url'), function (trees) {
            // create an array with nodes
            var formattedTrees = trees.map(function (tree) {
                return [tree].concat(tree.children.reduce(flat, [])).map(function (item) {
                    return {
                        id: item.id,
                        label: item.name + '(' + item.employeeSkillLevel + ')',
                        level: item.level,
                        widthConstraint: {maximum: 170},
                        color: {background:getColor(100 - item.employeeSkillLevel * 10), border:'#000000'}
                    };
                })
            });
            var nodes = new vis.DataSet(formattedTrees.reduce(function (a, b) {
                return a.concat(b);
            }));
            // create an array with edges
            var formattedNestedEdges = trees.map(function (tree) {
                return getEdges(tree, [])
            });
            var edges = new vis.DataSet(formattedNestedEdges.reduce(function (a, b) {
                return a.concat(b);
            }));

            // create a network
            network.setData({
                nodes: nodes,
                edges: edges
            });
        });
    }

    setVisJsData();
});