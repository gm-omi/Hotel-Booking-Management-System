<?php

include __DIR__ . '/../Layouts/adminHeader.php';

?>

<div class="list-container">

    <h2>Room Types</h2>

    <!-- Back to Admin Dashboard Button -->
    <div style="margin-bottom: 15px;">
        <a href="../Views/adminDashboard.php" 
           style="background: #6c757d; 
                  color: white; 
                  padding: 8px 20px; 
                  text-decoration: none; 
                  border-radius: 30px; 
                  display: inline-block;">
            ← Back to Admin Dashboard
        </a>
    </div>

    <?php if(isset($_SESSION['message'])) { ?>

        <div class="alert alert-success">
            <?php
            echo $_SESSION['message'];
            unset($_SESSION['message']);
            ?>
        </div>

    <?php } ?>

    <a
        href="/HotelBookingSystemMerged/Controller/roomTypeController.php?action=create"
        class="btn btn-primary"
    >
        + Add Room Type
    </a>

    <div style="overflow-x: auto;">

        <table class="data-table">

            <thead>

                <tr>

                    <th>ID</th>

                    <th>Name</th>

                    <th>Price (৳)</th>

                    <th>Capacity</th>

                    <th>Amenities</th>

                    <th>Image</th>

                    <th>Actions</th>

                </tr>

            </thead>

            <tbody>

            <?php if(
                isset($roomTypes) &&
                count($roomTypes) > 0
            ) { ?>

                <?php foreach($roomTypes as $type) { ?>

                    <?php
                    
                    if(!isset($type['amenities_array']) && !empty($type['amenities'])) {
                        $type['amenities_array'] = json_decode($type['amenities'], true);
                    }
                    ?>

                    <tr>

                        <td>
                            <?php echo $type['id']; ?>
                        </td>

                        <td>
                            <?php
                            echo htmlspecialchars(
                                $type['name']
                            );
                            ?>
                        </td>

                        <td>
                            ৳<?php
                            echo number_format(
                                $type['price_per_night'],
                                2
                            );
                            ?>
                        </td>

                        <td>
                            <?php
                            echo $type['max_capacity'];
                            ?>
                            persons
                        </td>

                        <td>
                            <?php
                            $amenities = $type['amenities_array'] ?? [];
                            if(!empty($amenities)) {
                                echo implode(", ", $amenities);
                            } else {
                                echo "-";
                            }
                            ?>
                        </td>

                        <td class="image-cell">

                            <?php if(
                                !empty($type['thumbnail_path'])
                            ) { ?>

                               <img

                                    src="../public/<?php
                                        echo $type['thumbnail_path'];
                                        ?>"

                                    class="img-thumb clickable-image"

                                    alt="<?php
                                    echo htmlspecialchars(
                                        $type['name']
                                    );
                                    ?>"

                                    onclick="showImage(
                                        '../public/<?php
                                        echo $type['thumbnail_path'];
                                        ?>'
                                    )"

                                    title="Click to enlarge"
                                    >

                            <?php } else { ?>

                                <span class="no-image">
                                    No Image
                                </span>

                            <?php } ?>

                        </td>

                        <td class="actions-cell">

                            <a
                                href="../Controller/roomTypeController.php?action=edit&id=<?php echo $type['id']; ?>"
                                class="btn btn-primary btn-sm"
                            >
                                Edit
                            </a>

                        </td>

                    </tr>

                <?php } ?>

            <?php } else { ?>

                <tr>

                    <td colspan="7" style="text-align:center;">
                        No room types found.

                        <a href="../Controller/roomTypeController.php?action=create">
                            Add one
                        </a>
                    </td>

                </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>

</div>


<div id="imageModal" class="modal" onclick="closeModal()">

    <span class="close-modal">
        &times;
    </span>

    <img
        class="modal-content"
        id="modalImage"
    >

</div>

<script>

function showImage(src)
{

    var modal =
    document.getElementById(
        'imageModal'
    );



    var modalImg =
    document.getElementById(
        'modalImage'
    );



    modal.style.display = "block";

    modalImg.src = src;

}



function closeModal()
{

    document.getElementById(
        'imageModal'
    ).style.display = "none";

}




document.addEventListener(
    'keydown',
    function(e)
    {

        if(e.key === 'Escape')
        {

            closeModal();

        }

    }

);



// Prevent click on image from bubbling to modal
document.getElementById(
    'modalImage'
).addEventListener(
    'click',
    function(e)
    {

        e.stopPropagation();

    }

);

</script>

<?php

include __DIR__ . '/../Layouts/adminFooter.php';

?>