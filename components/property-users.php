<section id="property" class="ja-items-center grid">
                    <h1 class="text-center none">Property</h1>
                        <div class="property-container grid">
                            <div class="splash-container grid two-column-grid-always">
                                <div class="cover-image bg-cover" style="background-image: url('images/properties/<?=$jAgentProperty->images[0]; ?>')">

                                    <?php foreach ($jLoggedUserFavorites as $jLoggedUserFavorite) {}
                                        
                                    if($jLoggedUserFavorite === $sPropertyId){?>
                                            <a class="likeBtn"><div class="likeBtnIcon active bg-contain"></div></a>
                                            <?php
                                    }
                                    if($jLoggedUserFavorite !== $sPropertyId){?>
                                            <a class="likeBtn"><div class="likeBtnIcon inactive bg-contain"></div></a>
                                            <?php

                                    }
                                ?>

                                </div>
                                <div class="property-info1">
                                    <h2><?= $jAgentProperty->address->street.' '.$jAgentProperty->address->streetnumber; ?></h2>
                                    <h2><?= $jAgentProperty->address->postalcode.' '.$jAgentProperty->address->city; ?></h2>
                                    <h2><?= $jAgentProperty->price; ?> kr</h2>
                                    <div class="update-buttons grid">
                                        <a class="button" href="mailto:<?= $jAgent->email; ?>">Contact Agent</a>
                                    </div>
                                </div>
                            </div>
                        
                        <div class="property-info2 grid four-column-grid ja-items-center">
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

                        <div class="cta">
                            <h1 class="text-center">COULD THIS BE YOUR NEW DREAM HOME?</h1>
                            <div class="cta-container grid two-column-grid-always">
                                <div class="agent-container grid two-column-grid-forever">
                                    <div class="agent-cta-image bg-cover" style="background-image: url('images/agents/<?=$jAgent->image; ?>')"></div>
                                    <div class="agent-cta-text grid">
                                        <h2>I'm <?=$jAgent->firstName;?></h2>
                                        <h2>Your agent</h2>
                                        <p>I would love to tell you more and show you the listing.</p>
                                    </div>  
                                </div>    
                                <div class="agent-enquiry-container bg-blue color-white">
                                    <form id="enquiry" class="grid" action="" method="POST">
                                        <input type="text" class="" name="txtEnquiry" id="enquiryMessage" placeholder="Your message" placeholder="Description" maxlength="100" data-type="string" data-min="20" data-max="100" value="">
                                        <a class="button" href="" id="makeEnquiry">Contact agent</a>
                                    </form>
                                </div>  
                            </div>
                        </div>
                </section>
