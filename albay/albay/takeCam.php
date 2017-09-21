 <?php


 ?>

 <div id="my_camera" ></div>

                         <input type=button value="Take Snapshot" id='takeShot' style="margin-top:1%;" onClick="take_snapshot()">
  
                       
                        
                          
                          <!-- Configure a few settings and attach camera -->
                          <script language="JavaScript">
                            Webcam.set({
                              width: 320,
                              height: 240,
                              image_format: 'jpeg',
                              jpeg_quality: 90
                            });
                            Webcam.attach( '#my_camera' );
                          </script>