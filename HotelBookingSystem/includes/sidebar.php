<div class="sidebar">

<?php

if($_SESSION['role'] == "admin")
{

?>

<a href="../Views/adminDashboard.php">

Admin Dashboard

</a>



<a  href="../Views/adminBookings.php">

Manage Bookings

</a>



<a href="../Controller/roomTypeController.php?action=list">

Room Types

</a>



<a href="../Controller/AdminRoomController.php?action=list">

Rooms

</a>



<a href="../Views/profile.php">

Profile

</a>

<?php

}

else
{

?>

<a href="../Views/searchRoom.php">

Search Rooms

</a>



<a href="../Views/myBookings.php">

My Bookings

</a>



<a href="../Views/profile.php">

Profile

</a>

<?php

}

?>

</div>