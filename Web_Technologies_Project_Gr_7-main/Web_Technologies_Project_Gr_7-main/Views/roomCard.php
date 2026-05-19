<div class="room-card">

    <div class="room-image">

        <img
        src="../public/<?php echo $row['thumbnail_path']; ?>">

    </div>



    <div class="room-info">

        <h2>

            <?php echo $row['name']; ?>

        </h2>



        <p>

            <?php echo $row['description']; ?>

        </p>



        <p>

            <strong>

            Guest Capacity:

            </strong>

            <?php echo $row['max_capacity']; ?>

        </p>



        <p>

            <strong>

            Amenities:

            </strong>

            <?php echo $row['amenities']; ?>

        </p>

    </div>



    <div class="room-side">

        <p>

            Price Per Night

        </p>



        <div class="room-price">

            BDT
            <?php echo $row['price_per_night']; ?>

        </div>



        <a href="../Views/bookingForm.php
        ?room_type_id=<?php echo $row['id']; ?>

        &checkin=<?php echo $checkin; ?>

        &checkout=<?php echo $checkout; ?>

        &guests=<?php echo $guests; ?>">

            <button class="simple-btn">

                Book Now

            </button>

        </a>

    </div>

</div>