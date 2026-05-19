<?php

include __DIR__ . '/../Layouts/adminHeader.php';

$errors = $errors ?? [];

$old    = $old    ?? [];

$room   = $room   ?? null;

?>

<div class="form-container">

    <h2 class="page-title">

        <?php

        if(isset($room))
        {

            echo "Edit Room";

        }

        else
        {

            echo "Add New Room";

        }

        ?>

    </h2>

    <form method="POST">

        <?php if(isset($room['id'])) { ?>

            <input
                type="hidden"
                name="room_id"
                value="<?php echo (int)$room['id']; ?>"
            >

        <?php } ?>

        <table class="form-table">

            <!-- Room Number -->
            <tr>

                <th>
                    Room Number
                </th>

                <td>

                    <input
                        type="text"
                        name="room_number"
                        value="<?php
                            echo htmlspecialchars(
                                $old['room_number'] ?? ''
                            );
                        ?>"
                    >

                </td>

                <td class="error-msg">
                    <?php
                        echo htmlspecialchars(
                            $errors['room_number'] ?? ''
                        );
                    ?>
                </td>

            </tr>

            <!-- Floor -->
            <tr>

                <th>
                    Floor
                </th>

                <td>

                    <input
                        type="number"
                        name="floor"
                        value="<?php
                            echo htmlspecialchars(
                                $old['floor'] ?? ''
                            );
                        ?>"
                    >

                </td>

                <td class="error-msg">
                    <?php
                        echo htmlspecialchars(
                            $errors['floor'] ?? ''
                        );
                    ?>
                </td>

            </tr>

            <!-- Room Type -->
            <tr>

                <th>
                    Room Type
                </th>

                <td>

                    <select name="room_type_id">

                        <option value="">
                            Select Type
                        </option>

                        <?php foreach($roomTypes as $type) { ?>

                            <option
                                value="<?php echo (int)$type['id']; ?>"
                                <?php
                                    echo (
                                        ($old['room_type_id'] ?? '')
                                        == $type['id']
                                    )
                                    ? 'selected'
                                    : '';
                                ?>
                            >

                                <?php
                                    echo htmlspecialchars(
                                        $type['name']
                                    );
                                ?>

                            </option>

                        <?php } ?>

                    </select>

                </td>

                <td class="error-msg">
                    <?php
                        echo htmlspecialchars(
                            $errors['room_type_id'] ?? ''
                        );
                    ?>
                </td>

            </tr>

            <!-- Status -->
            <tr>

                <th>
                    Status
                </th>

                <td>

                    <select name="status">

                        <option
                            value="available"
                            <?php
                                echo (
                                    ($old['status'] ?? '')
                                    == 'available'
                                )
                                ? 'selected'
                                : '';
                            ?>
                        >

                            Available

                        </option>

                        <option
                            value="occupied"
                            <?php
                                echo (
                                    ($old['status'] ?? '')
                                    == 'occupied'
                                )
                                ? 'selected'
                                : '';
                            ?>
                        >

                            Occupied

                        </option>

                        <option
                            value="maintenance"
                            <?php
                                echo (
                                    ($old['status'] ?? '')
                                    == 'maintenance'
                                )
                                ? 'selected'
                                : '';
                            ?>
                        >

                            Maintenance

                        </option>

                    </select>

                </td>

                <td class="error-msg">
                    <?php
                        echo htmlspecialchars(
                            $errors['status'] ?? ''
                        );
                    ?>
                </td>

            </tr>

            <!-- Submit -->
            <tr>

                <th></th>

                <td>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >

                        <?php

                        if(isset($room))
                        {

                            echo "Update Room";

                        }

                        else
                        {

                            echo "Create Room";

                        }

                        ?>

                    </button>

                </td>

                <td class="error-msg"></td>

            </tr>

        </table>

    </form>

</div>

<?php

include __DIR__ . '/../Layouts/adminFooter.php';

?>