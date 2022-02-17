<!DOCTYPE html>
<html>
    <html lang="ar">
    <!-- #Jordan -->
<head>
    <meta http-equiv="Main-page" content="text/html;" charset="UTF-8">
    <meta name="viewport" content="width=device-width , initial-scale=1.0">
    <title>Academic Advising</title>
    <!-- "image/x-icon" -->
    <link rel="shortcut icon" href="images/Academic_Advising_favicon.ico" type="image/x-icon">
    <link href="css/Stylee.css" , rel ="stylesheet"/>
    <link href="css\main.css" , rel="stylesheet"/>
    <style>
    /* ctrl + / */

    #fontfamily{
        font-family: 'Roboto',sans-serif;
        }
</style>
<script type="text/javascript">
    // alert("Hello World!");
</script>
</head>

<body>

<heade>
    <div class="navbar">
        <div class="container" dir="rtl">
        <a class="logo" href="index.html"><img class="logo_navbar" src="images/logo.png"alt="الصفحة الرئيسية"> 
            <div class="logo-navbar-name">Academic Advising</div></a> 
             <img id="mobile-cta" class="mobile-menu" src="images/menu.svg" alt="افتح القائمة">   
    <nav>
        <img id="mobile-exit" class="mobile-menu-exit" src="images/exit.svg" alt="اغلق القائمة">
        <ul class="primary-nav">
            <li id="Home" class="current" ><a href="#main">  الصفحة الرئيسية</a></li>
            <li><a href="#featurs">الخصائص</a></li>
            <li><a href="#about-us">من نحن</a></li>
        </ul>
        <ul class="secondary-nav">
            <li class="create-schedule" ><a href="Pages/index.php">تسجل الدخول</a></li>
            <li><a href="#contact">تواصل معنا</a></li>
          </ul>
    </nav>
    </div>
</div>
</heade>

    <section id="main" class="main-section">
        <div class="container">
            <div class="left-col">
                <p class="subhead"> الإرشاد الأكاديمي &amp; والتوجيه </p>
                <h1 > توجيه  لمرحلتك الجامعية </h1>
              
                <div class="two-element">
                    <a href="Pages/index.php" class="primary-element"><img class="table-icon"src="images/calendar4-week.svg" alt="اعمل جدولك"><span>اعمل جدولك</span></a>
                    <a href="Pages/index.php" class="secondary-element"><img src="images/search.svg" alt="ابحث عن المواد"> <span>اعرف موادك</span> </a>

                </div>
            </div>
            <img src="images/Undraw/all-platform.svg" class="element-image"  alt="All platform">
        </div>

    </section>
    <section id="featurs" class="sec-section">
            <div class="container">
                <ul class="Featurs-list"dir="rtl">
                    <li> اعمل جدولك </li>
                    <li>اعرف موادك</li>
                    <li>راجع المواد  </li>
                    <li> ادخل في دورة</li>
                    <li> وامور اخره استكشفها !  </li>
                </ul>
                
             <img src="images/Undraw/design_components.svg" alt="اصنع جدولك">

            </div>

    </section>
        <section id="about-us" class="third-section">
            <div class="container">
              <ul dir="rtl">
                <li> 
                    <img src="images/AAydi.jpg" alt="عبدالرحمن">
                    <blockquote>" طالب هندسة البرمجيات ولدي خبرة ممتازة في العديد من لغات البرمجة حتى في أتمتة العمليات الروبوتية سريع التعلم واسعى دائما لتطوير مهاراتي التقنية والشخصية ولقد قمت بتصميم وبناء العديد من التطبيقات والمواقع الالكترونية, اعتبر نفسي شخص لديه القدرة على تحليل وحل المشاكل ولا اترك المهام إلا بعد إنجازها. "</blockquote>
                    <cite>- عبدالرحمن عزمي</cite>
                </li>
                <li> 
                    <img src="images/Undraw/dev_productivity_.svg" alt="محمد">
                    <blockquote>"نص عن محمد"</blockquote>
                    <cite>- محمد ابوحسين</cite>
                </li>
                <li> 
                    <img src="images/Undraw/dev_productivity_.svg" alt="غفران">
                    <blockquote>"نص عن غفران"</blockquote>
                    <cite>- غفران عبدالله </cite>
                </li>
              </ul>
            </div>

        </section>
        <?php
        if (!empty($errors)) {
           $allErrors = join('<br/>', $errors);
           $errorMessage = "<p style='color: red;'>{$allErrors}</p>";
        }?>
            <?php
$errors = [];
$errorMessage = '';
$Success='';
if (!empty($_POST)) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    if (empty($name)) {
        $errors[] = 'Name is empty';
    }

    if (empty($email)) {
        $errors[] = 'Email is empty';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email is invalid';
    }

    if (empty($message)) {
        $errors[] = 'Message is empty';
    }

    if (empty($errors)) {
        $toEmail = 'academic.advising.wise@gmail.com';
        $emailSubject = 'New email from your contant form';
        $headers = ['From' => $email, 'Reply-To' => $email, 'Content-type' => 'text/html; charset=UTF-8'];

        $bodyParagraphs = ["الاسم: {$name}", "<br>Email: {$email}", "<br>الرسالة:", $message];
        $body = join(PHP_EOL, $bodyParagraphs);

        if (mail($toEmail, $emailSubject, $body, $headers)) {
            $Success="<p style='color: green;'>لقد تم إرسال ايميلك <br> شكرا لتواصلك معنا </p>";
        } else {
            $errorMessage = 'Oops, something went wrong. Please try again later';
        }
    } else {
        $allErrors = join('<br/>', $errors);
        $errorMessage = "<p style='color: red;'>{$allErrors}</p>";
    }
}
        ?>
        <section id="contact" class="contant-section">
            <div class="container" dir="rtl">
                <div class="contact-left">
                    <h2>تواصل معنا</h2>
                    <form method="POST" id="contactform" autocomplete="off">

                    <?php echo((!empty($errorMessage)) ? $errorMessage : '') ?>
                    <?php echo((!empty($Success)) ? $Success : '') ?>

                        <label for="name">الاسم :</label>
                        <input type="text" id="name" name="name">

                        <label for="email">الإيميل :</label>
                        <input type="text" id="email" name="email" placeholder="" required >
                        <span class="error-message">ارجوك ادخل ايميل صالح</span>
                            
                        <label for="message">الرسالة :</label>
                        <textarea name="message" id="message" cols="40" rows="14" placeholder="اكتب اي تعليق او استفسار .."></textarea>

                        <input type="submit" data-action='submit' value="ارسل الرسالة">
                        <!-- <input type="submit" class="g-recaptcha"   data-sitekey="reCAPTCHA_site_key"   -->
                        <!-- class="send-message"  data-callback='onSubmit'   data-action='submit' value="ارسل الرسالة"> -->
                        <div class="thankyou_message" style="display:none;">
                            <h3><em>Thanks</em> for contacting us!</h3>
                            <h3>
                                We will get back to you soon!</h3>
                        </div>
                         <!-- Back End to protects you against spam and other types of 
                        automated abuse <script src="https://www.google.com/recaptcha/api.js"></script> -->
                    </form>
                    <script src="//cdnjs.cloudflare.com/ajax/libs/validate.js/0.13.1/validate.min.js"></script>
  <script>
      const constraints = {
          name: {
              presence: { allowEmpty: false }
          },
          email: {
              presence: { allowEmpty: false },
              email: true
          },
          message: {
              presence: { allowEmpty: false }
          }
      };

      const form = document.getElementById('contactform');

      form.addEventListener('submit', function (event) {
          const formValues = {
              name: form.elements.name.value,
              email: form.elements.email.value,
              message: form.elements.message.value
          };

          const errors = validate(formValues, constraints);

          if (errors) {
              event.preventDefault();
              const errorMessage = Object
                  .values(errors)
                  .map(function (fieldValues) {
                      return fieldValues.join(', ')
                  })
                  .join("\n");

              alert(errorMessage);
          }
      }, false);
  </script>
                </div>
                <div class="contact-right">
                     <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13532.733994679575!2d35.94572606957541!3d32.01014273644433!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x422b60b0d9a86253!2z2KzYp9mF2LnYqSDYp9mE2LnZhNmI2YUg2KfZhNil2LPZhNin2YXZitipINin2YTYudin2YTZhdmK2Kk!5e0!3m2!1sar!2sjo!4v1615548295777!5m2!1sar!2sjo" 
                     style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>

        </section>


 
    <!-- <h3 title = "this is a hint!">hoverd me to see the hint </h3> -->


<footer>
    <p>Copyright 2021 © All rights reserved.</p>
    <hr>
    <p  >Academic Advising</p>
</footer>

<script src="JS/JavaScript.js"></script>
</body>
</html>