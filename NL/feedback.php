<?php
session_cache_limiter('none');
session_start();
ob_start();
?><!DOCTYPE html>
<html lang="en"><!-- InstanceBegin template="/Templates/master.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<?php include "head.php" ?>
<!-- InstanceBeginEditable name="doctitle" -->
<title>Feedback - Neon Light</title>
<script type="text/javascript" src="livevalidation.js"></script>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
</head>
<body>
<?php include "header.php" ?>
<div class="container">
<div class="bgsetm">
<div class="row">
<?php include "left.php" ?>
<div  class="col-xs-12 col-lg-9 col-sm-9">
<div class="middbox">
          <div class="row">
          <div class="col-xs-12 col-sm-12">
<!-- InstanceBeginEditable name="body" -->
       <div class="pation"><h1>Feedback</h1></div>
<form action="http://ec2-75-101-179-88.compute-1.amazonaws.com/" enctype="multipart/form-data" method="post" name="Feedback" id="Feedback">
<input type="hidden" name="toemail" value="73616c6573406e656f6e2d6c696768742e6e6574"><!--sales@neon-light.net -->
<input type="hidden" name="subject" value="Feedback - {fName}">
<input type="hidden" name="return_url" value="http://www.neon-light.net/thank-you.php">


<p>* Required information</p>

<div class="form-group">
<div class="row">
    <label for="inputEmail3" class="col-sm-3 control-label"><span class="redst">*</span>Name</label>
<div class="col-sm-9"><input type="text" name="fName" id="fName" class="form-control" placeholder="Enter full name">
            <script language="javascript" type="text/javascript">
             var fName = new LiveValidation('fName');
             fName.add( Validate.Presence );
			 fName.add( Validate.Exclusion, { within: [ '@' , '.net' , '.org' , '.com' ], partialMatch: true } );
			</script></div></div></div>
            
            
<div class="form-group"><div class="row">
    <label for="inputEmail3" class="col-sm-3 control-label"><span class="redst">*</span>Email:</label>
            <div class="col-sm-9"><input type="text" x-autocompletetype="email" class="form-control" value="" id="email" name="email" placeholder="Enter email">
          <script type="text/javascript" language="javascript">
                         			 var email = new LiveValidation('email');
									 email.add( Validate.Presence );
									 email.add( Validate.Email );
						  		</script></div></div></div>
                               
<div class="form-group"><div class="row">
    <label for="inputEmail3" class="col-sm-3 control-label">Customer Service:</label>
            <div class="col-sm-7"><select id="customerservice" name="customerservice" class="form-control">
                                  <option selected="selected" value="0">Customer Service..</option>
                                  <option value="1">1</option>
                                  <option value="2">2</option>
                                  <option value="3">3</option>
                                  <option value="4">4</option>
                                  <option value="5">5</option>
                                </select></div><div class="col-sm-2"><small>5 is Best</small> </div></div></div>
            
<div class="form-group"><div class="row">
    <label for="inputEmail3" class="col-sm-3 control-label">Quality of Neon Sign:</label>
            <div class="col-sm-7"><select id="quality" name="quality" class="form-control">
                                  <option selected="selected" value="0">Quality of Neon Sign..</option>
                                  <option value="1">1</option>
                                  <option value="2">2</option>
                                  <option value="3">3</option>
                                  <option value="4">4</option>
                                  <option value="5">5</option>
                                </select></div><div class="col-sm-2"><small>5 is Best</small></div></div></div>        
               
<div class="form-group"><div class="row">
    <label for="inputEmail3" class="col-sm-3 control-label">Speed of delivery:</label>
             <div class="col-sm-7"><select id="delivery" name="delivery" class="form-control">
                                  <option selected="selected" value="0">Speed of delivery..</option>
                                  <option value="1">1</option>
                                  <option value="2">2</option>
                                  <option value="3">3</option>
                                  <option value="4">4</option>
                                  <option value="5">5</option>
                                </select></div><div class="col-sm-2"><small>5 is Best</small></div></div></div>         
                
<div class="form-group"><div class="row">
    <label for="inputEmail3" class="col-sm-3 control-label">Over all Experience:</label>                
        <div class="col-sm-7"><select id="experience" name="experience" class="form-control">
                                  <option selected="selected" value="0">Over all Experience..</option>
                                  <option value="1">1</option>
                                  <option value="2">2</option>
                                  <option value="3">3</option>
                                  <option value="4">4</option>
                                  <option value="5">5</option>
                                </select></div><div class="col-sm-2"><small>5 is Best</small></div></div></div>       
               
 <div class="form-group"><div class="row">
    <label for="inputEmail3" class="col-sm-3 control-label">Comments/Suggestion on improving the website:</label>                
        <div class="col-sm-9"><textarea name="describe_issue" id="describe_issue" rows="5" class="form-control"></textarea></div></div></div>
                                
                                        
 <div class="form-group"><div class="row">
    <label for="inputEmail3" class="col-sm-3 control-label">Upload Sign Image:</label>                
        <div class="col-sm-9"><input type="file" name="fileField" id="fileField" class="form-control"></div></div></div>   
 <div class="form-group"><div class="row">
    <div class="col-sm-offset-3 col-sm-9">
      <button type="submit" class="btn btn-primary">Submit</button>
    </div></div>
  </div> 
  </form>
  
  <br />
<br />
<div align="center"><?php include "inc-banner.php" ?></div>
		<!-- InstanceEndEditable --></div>
        </div>
          </div>
        </div>
      </div>
      </div>
    </div>
<?php include "footer.php" ?>
<?php include "footerscript.php" ?>
  </body>
<!-- InstanceEnd --></html>
