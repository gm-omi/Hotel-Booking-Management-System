<?php

include __DIR__ . '/../Layouts/adminHeader.php';

?>

<div class="form-container">

    <h2>
        <?php
        echo isset($old['id']) && $old['id']
        ? 'Edit'
        : 'Add';
        ?>
        Room Type
    </h2>

    <!-- Back Button -->
    <div class="back-button">
        <a href="roomTypeController.php?action=list" class="btn-back">
            ← Back to Room Types List
        </a>
    </div>

    <?php if(!empty($errors)) { ?>

        <div class="alert alert-error">
            Please fix the errors below.
        </div>

    <?php } ?>

    <form method="POST" enctype="multipart/form-data">

        <table class="form-table">

            
            <tr>
                <th>Name:</th>
                <td>
                    <select name="name" class="form-select" required>
                        <option value="">
                            -- Select Room Type --
                        </option>
                        <option value="Standard" 
                            <?php echo (isset($old['name']) && $old['name'] == 'Standard') ? 'selected' : ''; ?>>
                            Standard
                        </option>
                        <option value="Deluxe" 
                            <?php echo (isset($old['name']) && $old['name'] == 'Deluxe') ? 'selected' : ''; ?>>
                            Deluxe
                        </option>
                        <option value="Suite" 
                            <?php echo (isset($old['name']) && $old['name'] == 'Suite') ? 'selected' : ''; ?>>
                            Suite
                        </option>
                    </select>
                </td>
                <td class="error-msg">
                    <?php 
                    echo isset($errors['name']) 
                    ? $errors['name'] 
                    : ''; 
                    ?>
                </td>
            </tr>

            
            <tr>
                <th>Description:</th>
                <td>
                    <textarea name="description" class="form-textarea" rows="3">
                        <?php 
                        echo htmlspecialchars(
                            $old['description'] ?? ''
                        ); 
                        ?>
                    </textarea>
                </td>
                <td class="error-msg">
                    <?php 
                    echo isset($errors['description']) 
                    ? $errors['description'] 
                    : ''; 
                    ?>
                </td>
            </tr>

            
            <tr>
                <th>Price Per Night:</th>
                <td>
                    <input 
                        type="number" 
                        step="500" 
                        name="price_per_night" 
                        min="0" 
                        class="form-input" 
                        value="<?php echo $old['price_per_night'] ?? ''; ?>">
                    ৳
                </td>
                <td class="error-msg">
                    <?php 
                    echo isset($errors['price_per_night']) 
                    ? $errors['price_per_night'] 
                    : ''; 
                    ?>
                </td>
            </tr>

            
            <tr>
                <th>Max Capacity:</th>
                <td>
                    <input 
                        type="number" 
                        name="max_capacity" 
                        min="1" 
                        max="8" 
                        class="form-input-small" 
                        value="<?php echo $old['max_capacity'] ?? ''; ?>">
                    <small>(Max 8 persons)</small>
                </td>
                <td class="error-msg">
                    <?php 
                    echo isset($errors['max_capacity']) 
                    ? $errors['max_capacity'] 
                    : ''; 
                    ?>
                </td>
            </tr>

            
            <tr>
                <th>Thumbnail:</th>
                <td>
                    <input 
                        type="file" 
                        name="thumbnail" 
                        accept="image/jpeg,image/png" 
                        class="form-file">
                    <?php if(!empty($old['thumbnail_path'])) { ?>
                        <br>
                        <img 
                            src="../<?php echo $old['thumbnail_path']; ?>" 
                            class="img-thumb" 
                            width="60">
                    <?php } ?>
                </td>
                <td class="error-msg">
                    <?php 
                    echo isset($errors['thumbnail']) 
                    ? $errors['thumbnail'] 
                    : ''; 
                    ?>
                </td>
            </tr>

            
            <tr>
                <th>Amenities:</th>
                <td>
                    <?php 
                    $selected = $old['amenities_array'] ?? []; 
                    ?>
                    
                    <label>
                        <input 
                            type="checkbox" 
                            name="amenities[]" 
                            value="WiFi" 
                            <?php 
                            echo in_array('WiFi', $selected) 
                            ? 'checked' 
                            : ''; 
                            ?>>
                        WiFi
                    </label>
                    <br>
                    
                    <label>
                        <input 
                            type="checkbox" 
                            name="amenities[]" 
                            value="AC" 
                            <?php 
                            echo in_array('AC', $selected) 
                            ? 'checked' 
                            : ''; 
                            ?>>
                        AC
                    </label>
                    <br>
                    
                    <label>
                        <input 
                            type="checkbox" 
                            name="amenities[]" 
                            value="TV" 
                            <?php 
                            echo in_array('TV', $selected) 
                            ? 'checked' 
                            : ''; 
                            ?>>
                        TV
                    </label>
                    <br>
                    
                    <label>
                        <input 
                            type="checkbox" 
                            name="amenities[]" 
                            value="Mini-bar" 
                            <?php 
                            echo in_array('Mini-bar', $selected) 
                            ? 'checked' 
                            : ''; 
                            ?>>
                        Mini-bar
                    </label>
                    <br>
                    
                    <label>
                        <input 
                            type="checkbox" 
                            name="amenities[]" 
                            value="Safe" 
                            <?php 
                            echo in_array('Safe', $selected) 
                            ? 'checked' 
                            : ''; 
                            ?>>
                        Safe
                    </label>
                    <br>
                    
                    <label>
                        <input 
                            type="checkbox" 
                            name="amenities[]" 
                            value="Bathtub" 
                            <?php 
                            echo in_array('Bathtub', $selected) 
                            ? 'checked' 
                            : ''; 
                            ?>>
                        Bathtub
                    </label>
                    <br>
                    
                    <label>
                        <input 
                            type="checkbox" 
                            name="amenities[]" 
                            value="Balcony" 
                            <?php 
                            echo in_array('Balcony', $selected) 
                            ? 'checked' 
                            : ''; 
                            ?>>
                        Balcony
                    </label>
                </th>
                <td class="error-msg">
                    <?php 
                    echo isset($errors['amenities']) 
                    ? $errors['amenities'] 
                    : ''; 
                    ?>
                </th>
            </tr>

            
            <tr>
                <th></th>
                <td>
                    <button type="submit" class="btn-save">
                        Save
                    </button>
                    
                    <a href="roomTypeController.php?action=list" class="btn-cancel">
                        Cancel
                    </a>
                </td>
                <td class="error-msg">
                </td>
            </tr>

        </table>

    </form>

</div>

<?php

include __DIR__ . '/../Layouts/adminFooter.php';

?>