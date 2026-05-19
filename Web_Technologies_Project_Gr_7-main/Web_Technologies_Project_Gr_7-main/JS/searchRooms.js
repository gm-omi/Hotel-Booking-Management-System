function searchRooms()
{

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

    document.getElementById(
    "searchError"
).innerHTML = "";







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

            document.getElementById(
                "roomResults"
            ).innerHTML =
            this.responseText;

        }

    };




    xhttp.open(

        "GET",

        "../Controller/roomSearchController.php"

        +

        "?checkin=" + checkin

        +

        "&checkout=" + checkout

        +

        "&guests=" + guests,

        true

    );



    xhttp.send();

}