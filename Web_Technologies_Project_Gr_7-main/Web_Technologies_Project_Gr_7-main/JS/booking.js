function loadBookings()
{

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function()
    {

        if(this.readyState == 4 && this.status == 200)
        {

            document.getElementById(
                "bookingTable"
            ).innerHTML = this.responseText;

        }

    };



    xhttp.open(
        "GET",
        "../Controller/showBookings.php",
        true
    );



    xhttp.send();

}




function confirmBooking(id)
{

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function()
    {

        if(this.readyState == 4 && this.status == 200)
        {

            loadBookings();

        }

    };



    xhttp.open(
        "POST",
        "../Controller/bookingController.php",
        true
    );



    xhttp.setRequestHeader(
        "content-type",
        "application/x-www-form-urlencoded"
    );



    xhttp.send(
        "action=confirm&booking_id=" + id
    );

}




function checkInBooking(id)
{

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function()
    {

        if(this.readyState == 4 && this.status == 200)
        {

            loadBookings();

        }

    };



    xhttp.open(
        "POST",
        "../Controller/bookingController.php",
        true
    );



    xhttp.setRequestHeader(
        "content-type",
        "application/x-www-form-urlencoded"
    );



    xhttp.send(
        "action=checkin&booking_id=" + id
    );

}




function checkOutBooking(id)
{

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function()
    {

        if(this.readyState == 4 && this.status == 200)
        {

            loadBookings();

        }

    };



    xhttp.open(
        "POST",
        "../Controller/bookingController.php",
        true
    );



    xhttp.setRequestHeader(
        "content-type",
        "application/x-www-form-urlencoded"
    );



    xhttp.send(
        "action=checkout&booking_id=" + id
    );

}




function confirmRoomBooking()
{

    let roomTypeId =
    document.getElementById(
        "room_type_id"
    ).value;



    let checkin =
    document.getElementById(
        "checkin"
    ).value;



    let checkout =
    document.getElementById(
        "checkout"
    ).value;



    let guests =
    document.getElementById(
        "guests"
    ).value;





    let xhttp =
    new XMLHttpRequest();




    xhttp.onreadystatechange =
    function()
    {

        if(
            this.readyState == 4
            &&
            this.status == 200
        )
        {

            document
            .getElementById(
                "bookingArea"
            )

            .innerHTML =

            this.responseText;

        }

    };




    xhttp.open(

        "POST",

        "../Controller/bookingController.php",

        true

    );




    xhttp.setRequestHeader(

        "Content-type",

        "application/x-www-form-urlencoded"

    );




    xhttp.send(

        "action=book"

        +

        "&room_type_id=" + roomTypeId

        +

        "&checkin=" + checkin

        +

        "&checkout=" + checkout

        +

        "&guests=" + guests

    );

}




function cancelBooking(bookingId)
{

    let xhttp =
    new XMLHttpRequest();




    xhttp.onreadystatechange =
    function()
    {

        if(
            this.readyState == 4
            &&
            this.status == 200
        )
        {

            alert(
                this.responseText
            );



            location.reload();

        }

    };




    xhttp.open(

        "POST",

        "../Controller/bookingController.php",

        true

    );




    xhttp.setRequestHeader(

        "Content-type",

        "application/x-www-form-urlencoded"

    );




    xhttp.send(

        "action=cancel"

        +

        "&booking_id=" + bookingId

    );

}




window.onload = loadBookings;