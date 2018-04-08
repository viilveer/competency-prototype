$(document).ready(function () {
    var container = $('#tree');

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
        console.log(level);
        var lightness = 30;
        if (level > 30) {
            lightness = level;
        }
        return ["hsl(120,100%,"+ lightness +"%)"].join("");
    }


    function setVisJsData() {
        $.getJSON(container.data('remote-url'), function (tree) {
            // create an array with nodes
            var nodes = new vis.DataSet([tree].concat(tree.children.reduce(flat, [])).map(function (item) {
                return {
                    id: item.id,
                    label: item.name + '(' + item.employeeSkillLevel + ')',
                    level: item.level,
                    widthConstraint: {maximum: 170},
                    color: {background:getColor(100 - item.employeeSkillLevel * 10), border:'#000000'}
                };
            }));
            // create an array with edges
            var edges = new vis.DataSet(getEdges(tree, []));

            // create a network
            network.setData({
                nodes: nodes,
                edges: edges
            });
        });
    }

    setVisJsData();
});