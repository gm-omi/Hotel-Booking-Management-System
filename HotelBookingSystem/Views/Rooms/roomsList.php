<?php

include __DIR__ . '/../Layouts/adminHeader.php';

?>

<div class="container">
    <h2>Room Management</h2>

    <a href="../Views/adminDashboard.php" class="btn btn-primary" style="margin-bottom: 15px; display: inline-block;">
        ← Back to Admin Dashboard
    </a>

    <div id="messageBox"></div>

    <div class="form-box">
        <h3 id="formTitle">Add Room</h3>

        <input type="hidden" id="roomId">

        <p>
            Room Number:
            <input type="number" id="roomNumber" placeholder="Enter Room Number" min="1" step="1">
        </p>

        <p>
            Floor:
            <input type="number" id="floor" placeholder="Enter Floor" min="0" step="1">
        </p>

        <p>
            Room Type:
            <select id="roomTypeId">
                <option value="">Select Type</option>
            </select>
        </p>

        <p>
            Status:
            <select id="status">
                <option value="available">Available</option>
                <option value="maintenance">Maintenance</option>
            </select>
        </p>

        <p>
            <button class="btn btn-primary" onclick="saveRoom()">Save</button>
            <button class="btn" onclick="clearForm()">Clear</button>
        </p>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Room Number</th>
                <th>Floor</th>
                <th>Type</th>
                <th>Occupancy</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="roomsTable"></tbody>
    </table>

</div>

<script>

function showMessage(msg, type)
{
    let color = type === 'success' ? 'green' : 'red';

    document.getElementById('messageBox').innerHTML = '<div style="color:' + color + ';padding:10px;">' + msg + '</div>';

    setTimeout(function()
    {
        document.getElementById('messageBox').innerHTML = '';
    }, 3000);
}

function loadRooms()
{
    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function()
    {
        if(this.readyState == 4 && this.status == 200)
        {
            let response = JSON.parse(this.responseText);
            let data = response.data;
            let rows = "";

            for(let i = 0; i < data.length; i++)
            {
                let room = data[i];
                let occClass = "";

                if(room.occupancy_status === "Available")
                {
                    occClass = "badge-success";
                }
                else if(room.occupancy_status === "Booked")
                {
                    occClass = "badge-warning";
                }
                else
                {
                    occClass = "badge-danger";
                }

                let statClass = "";
                let displayStatus = "";

                if(room.occupancy_status === "Booked")
                {
                    statClass = "badge-warning";
                    displayStatus = "Occupied";
                }
                else if(room.status === "available")
                {
                    statClass = "badge-success";
                    displayStatus = "Available";
                }
                else
                {
                    statClass = "badge-danger";
                    displayStatus = "Maintenance";
                }

                rows += "<tr>";
                rows += "<td style='text-align:center'>" + room.id + "</td>";
                rows += "<td style='text-align:center'>" + room.room_number + "</td>";
                rows += "<td style='text-align:center'>" + room.floor + "</td>";
                rows += "<td>" + room.room_type + "</td>";
                rows += "<td style='text-align:center'><span class='" + occClass + "'>" + room.occupancy_status + "</span></td>";
                rows += "<td style='text-align:center'><span class='" + statClass + " clickable' style='cursor:pointer;' onclick='toggleStatus(" + room.id + ")'>" + displayStatus + "</span></td>";
                rows += "<td style='text-align:center'><button class='btn btn-primary btn-sm' onclick='editRoom(" + room.id + ")'>Edit</button> <button class='btn btn-danger btn-sm' onclick='deleteRoom(" + room.id + ")'>Delete</button></td>";
                rows += "</tr>";
            }

            document.getElementById("roomsTable").innerHTML = rows;
        }
    };

    xhttp.open("POST", "../Controller/AdminRoomController.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("action=load");
}

function loadRoomTypes()
{
    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function()
    {
        if(this.readyState == 4 && this.status == 200)
        {
            let response = JSON.parse(this.responseText);
            let data = response.data;
            let options = "<option value=''>Select Type</option>";

            for(let i = 0; i < data.length; i++)
            {
                options += "<option value='" + data[i].id + "'>" + data[i].name + "</option>";
            }

            document.getElementById("roomTypeId").innerHTML = options;
        }
    };

    xhttp.open("POST", "../Controller/AdminRoomController.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("action=getRoomTypes");
}

function toggleStatus(id)
{
    if(!confirm("Toggle maintenance status for this room?"))
    {
        return;
    }

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function()
    {
        if(this.readyState == 4 && this.status == 200)
        {
            let response = JSON.parse(this.responseText);

            if(response.success)
            {
                showMessage("Status toggled successfully!", "success");
                loadRooms();
            }
            else
            {
                showMessage("Failed to toggle status!", "error");
            }
        }
    };

    xhttp.open("POST", "../Controller/AdminRoomController.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("action=toggle_status&id=" + encodeURIComponent(id));
}

function saveRoom()
{
    let id = document.getElementById("roomId").value;
    let roomNumber = document.getElementById("roomNumber").value;
    let floor = document.getElementById("floor").value;
    let roomType = document.getElementById("roomTypeId").value;
    let status = document.getElementById("status").value;

    if(!roomNumber)
    {
        showMessage("Room Number required!", "error");
        return;
    }

    if(roomNumber < 0)
    {
        showMessage("Room Number cannot be negative!", "error");
        return;
    }

    if(!floor && floor !== 0)
    {
        showMessage("Floor required!", "error");
        return;
    }

    if(floor < 0)
    {
        showMessage("Floor cannot be negative!", "error");
        return;
    }

    if(!roomType)
    {
        showMessage("Select room type!", "error");
        return;
    }

    let action = id ? 'update' : 'add';
    let data = "action=" + action + "&room_number=" + encodeURIComponent(roomNumber) + "&floor=" + encodeURIComponent(floor) + "&room_type_id=" + roomType + "&status=" + encodeURIComponent(status);

    if(id)
    {
        data += "&id=" + id;
    }

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function()
    {
        if(this.readyState == 4 && this.status == 200)
        {
            let response = JSON.parse(this.responseText);

            if(response.success)
            {
                showMessage(response.message || "Room saved!", "success");
                clearForm();
                loadRooms();
            }
            else
            {
                showMessage(response.message || "Error!", "error");
            }
        }
    };

    xhttp.open("POST", "../Controller/AdminRoomController.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(data);
}

function editRoom(id)
{
    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function()
    {
        if(this.readyState == 4 && this.status == 200)
        {
            let response = JSON.parse(this.responseText);
            let room = response.data;

            document.getElementById("roomId").value = room.id;
            document.getElementById("roomNumber").value = room.room_number;
            document.getElementById("floor").value = room.floor;
            document.getElementById("roomTypeId").value = room.room_type_id;
            document.getElementById("status").value = room.status;
            document.getElementById("formTitle").innerText = "Edit Room";
        }
    };

    xhttp.open("POST", "../Controller/AdminRoomController.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("action=getRoom&id=" + id);
}

function deleteRoom(id)
{
    if(confirm("Delete this room?"))
    {
        let xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function()
        {
            if(this.readyState == 4 && this.status == 200)
            {
                let response = JSON.parse(this.responseText);
                showMessage(response.message, response.success ? "success" : "error");
                if(response.success)
                {
                    loadRooms();
                }
            }
        };

        xhttp.open("POST", "../Controller/AdminRoomController.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("action=delete&id=" + id);
    }
}

function clearForm()
{
    document.getElementById("roomId").value = "";
    document.getElementById("roomNumber").value = "";
    document.getElementById("floor").value = "";
    document.getElementById("roomTypeId").value = "";
    document.getElementById("status").value = "available";
    document.getElementById("formTitle").innerText = "Add Room";
}

loadRooms();
loadRoomTypes();

</script>

<?php

include __DIR__ . '/../Layouts/adminFooter.php';

?>