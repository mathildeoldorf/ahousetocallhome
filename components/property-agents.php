<section id="property" class="ja-items-center grid">
                    <h1 class="text-center none">Property</h1>
                        <div class="property-container grid">
                            <div class="splash-container grid two-column-grid-always">
                                <div class="cover-image bg-cover" style="background-image: url('images/properties/<?=$jAgentProperty->images[0]; ?>')">
                                </div>
                                <div class="property-info1">
                                    <h2><?= $jAgentProperty->address->street.' '.$jAgentProperty->address->streetnumber; ?></h2>
                                    <h2><?= $jAgentProperty->address->postalcode.' '.$jAgentProperty->address->city; ?></h2>
                                    <h2><?= $jAgentProperty->price; ?> kr</h2>
                                    <div class="update-buttons grid two-column-grid-always">
                                        <a class="button" href="delete-property.php">Delete</a>
                                        <a id="updatePropertyBtn" class="button" href="">Update</a>
                                    </div>
                               
                                </div>
                            </div>
                        
                        <div class="property-info2 full-width grid four-column-grid ja-items-center">
                            <div class="detail">
                                <div class="icon bg-contain size margin-auto" style="background-image: url('images/size.png')"></div>
                                <h4><?= $jAgentProperty->size; ?> m2</h4>
                            </div>
                            <div class="detail">
                                <div class="icon bg-contain margin-auto" style="background-image: url('images/rooms.png')"></div>
                                <h4><?= $jAgentProperty->rooms; ?> Rooms</h4>
                            </div>
                            <div class="detail">
                                <div class="icon bg-contain beds margin-auto" style="background-image: url('images/beds.png')"></div>
                                <h4><?= $jAgentProperty->beds; ?> Bedrooms</h4>
                            </div>
                            <div class="detail">
                                <p><?= $jAgentProperty->description; ?></p>
                            </div>
                        </div>
                        <div class="images-square grid two-column-grid-always">
                            <div class="bg-cover" style="background-image: url('images/properties/<?=$jAgentProperty->images[0]; ?>')"></div>
                            <div class="bg-cover" style="background-image: url('images/properties/<?=$jAgentProperty->images[1]; ?>')"></div>
                        </div>
                        <div class="images-portrait grid two-column-grid-always mt-medium">
                            <div class="bg-cover" style="background-image: url('images/properties/<?=$jAgentProperty->images[2]; ?>')"></div>
                            <div class="bg-cover" style="background-image: url('images/properties/<?=$jAgentProperty->images[3]; ?>')"></div>
                        </div>
                        </div>
                
                </section>

                <section id="update-property-form" class="ja-items-center grid absolute">
    
                    <form class="update-property bg-blue grid one-column-grid" method="POST" enctype="multipart/form-data">
                    <a href="" class="close"> </a>
                    <h1 class="text-center">Update property</h1>
                        <div class="update-property-input-container grid two-column-grid-always">
                        <div>
                            <input id="images" id="images" name="images[]" type="file" placeholder="Images (Max. 4)" multiple>
                            <div class="button overlay-layer">Upload photos</div>
                        </div>
                        <input class="full-width" name="txtStreet" type="text" placeholder="Street (2-20 characters)" type="text" maxlength="20" data-type="string" data-min="2" data-max="20" value="<?= $jAgentProperty->address->street; ?>">
                        <input class="full-width" name="iStreetNumber" type="text" placeholder="Street number (1-5 characters)" type="text" maxlength="10" data-type="string" data-min="1" data-max="5" value="<?= $jAgentProperty->address->streetnumber; ?>">
                        <input class="full-width" name="iPostalCode" type="text" placeholder="Postal code (4 digits)" type="text" maxlength="4" data-type="string" data-min="4" data-max="4" value="<?= $jAgentProperty->address->postalcode; ?>">
                        <input class="full-width" name="txtCity" type="text" placeholder="City (2-30 character)" type="text" maxlength="30" data-type="string" data-min="2" data-max="30" value="<?=$jAgentProperty->address->city; ?>">
                        <input class="full-width" name="iPrice" type="text" placeholder="Price" maxlength="10" data-type="string" data-min="5" data-max="10" value="1200000" value="<?= $jAgentProperty->price; ?>">
                        <input class="full-width" name="iSize" type="text" placeholder="Size (Numbers only)" maxlength="4" data-type="string" data-min="2" data-max="4" value="<?= $jAgentProperty->size; ?>">
                        <input class="full-width" name="iBedrooms" type="text" placeholder="Bedrooms (Numbers only)" maxlength="4" data-type="string" data-min="2" data-max="4" value="<?= $jAgentProperty->beds; ?>">
                        <input class="full-width" name="iRooms" type="text" placeholder="Rooms (Numbers only)" maxlength="4" data-type="string" data-min="2" data-max="4" value="<?= $jAgentProperty->rooms; ?>">
                        </div>
                        <input class="full-width" name="txtDescription" type="text" placeholder="Description" maxlength="100" data-type="string" data-min="20" data-max="100" value="<?= $jAgentProperty->description; ?>">
                        <button id="updatePropertyFormBtn" class="full-width button">Update</button>
                    </form>
                </section>