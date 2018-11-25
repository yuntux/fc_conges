			<div id="bloc_donnees">
<script>
$(function(){
    var URL = "https://js.devexpress.com/Demos/Mvc/api/DataGridWebApi";
    var URL = " https://conges.fontaine-consultants.fr/api_server/v1/dispatcher.php?object=Projet&auth_token=<?php echo $_SESSION['mon_token']?>";

    var ordersStore = new DevExpress.data.CustomStore({
        key: "ID_PROJET",
        load: function() {
            return sendRequest(URL + "&method=get_list");
        },
       insert: function(values) {
		var tab = JSON.stringify(Array(JSON.stringify(values)));
		alert(tab);
		target = URL + "&method=add&args=" + "&args_array="+encodeURI(btoa(tab));
		alert(target)
            	res = sendRequest(target);
		//alert(JSON.parse(res));
		//return res;
        },
        update: function(key, values) {
		var tab = JSON.stringify(Array(key, JSON.stringify(values)));
		alert(tab);
		target = URL + "&method=update&args=" + "&args_array="+encodeURI(btoa(tab));
		alert(target)
            	res = sendRequest(target);
        },/*
        remove: function(key) {
            return sendRequest(URL + "/DeleteOrder", "DELETE", {
                key: key
            });
        }*/
    });

    var dataGrid = $("#grid").dxDataGrid({     
        dataSource: ordersStore,
        repaintChangesOnly: true,
        showBorders: true,
        editing: {
            refreshMode: "reshape",
            mode: "cell",
            allowAdding: true,
            allowUpdating: true,
            allowDeleting: true
        },
        scrolling: {
            mode: "virtual"
        },
        columns: [
		/*{
                dataField: "CustomerID",
                caption: "Customer",
                lookup: {
                    dataSource: {
                        paginate: true,
                        store: new DevExpress.data.CustomStore({
                            key: "Value",
                            loadMode: "raw",
                            load: function() {
                                return sendRequest(URL + "/CustomersLookup");
                            }
                        })
                    },
                    valueExpr: "Value",
                    displayExpr: "Text"
                }
            }, */
	    { 
                dataField: "NUM_PROJET",
                caption: "N° projet",
            }, { 
                dataField: "NOM_PROJET",
                caption: "Nom projet",
            },
        ]
    }).dxDataGrid("instance");

    $("#refresh-mode").dxSelectBox({
        items: ["full", "reshape", "repaint"],
        value: "reshape",
        onValueChanged: function(e) {
            dataGrid.option("editing.refreshMode", e.value);  
        }
    });

    $("#clear").dxButton({
        text: "Clear",
        onClick: function() {
            $("#requests ul").empty();
        }
    });

    function sendRequest(url, method, data) {
        var d = $.Deferred();
    
        method = method || "GET";

        logRequest(method, url, data);
    
        $.ajax(url, {
            method: method || "GET",
            data: data,
            cache: false,
            xhrFields: { withCredentials: true }
        }).done(function(result) {
           d.resolve(method === "GET" ? JSON.parse(result):result);
	  //d.resolve(JSON.parse(result));
        }).fail(function(xhr) {
            d.reject(xhr.responseJSON ? xhr.responseJSON.Message : xhr.statusText);
        });
    
        return d.promise();
    }

    function logRequest(method, url, data) {
        var args = Object.keys(data || {}).map(function(key) {
            return key + "=" + data[key];
        }).join(" ");

        var logList = $("#requests ul"),
            time = DevExpress.localization.formatDate(new Date(), "HH:mm:ss"),
            newItem = $("<li>").text([time, method, url.slice(URL.length), args].join(" "));
        
        logList.prepend(newItem);
    }
});
</script>

<body class="dx-viewport">
    <div class="demo-container">
        <div id="grid"></div>
        <div class="options">
            <div class="caption">Options</div>
            <div class="option">
                <span>Refresh Mode:</span>
                <div id="refresh-mode"></div>
            </div>
            <div id="requests">
                <div>
                    <div class="caption">Network Requests</div>
                    <div id="clear"></div>
                </div>
                <ul></ul>
            </div>
        </div>
    </div>
</body>
</div>
