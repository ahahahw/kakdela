<body style='background-image:url(8083665.kmx1pufmfy.jpg); background-size: cover; backdrop-filter: blur(14px);'>
<div style="display:flex; align-items: center;flex-direction: column;">
    <div style='padding-top:260px; font-size: 600%; color:white'>
        Ты живешь в:
    </div>
    <div style = 'font-size: 400%; color:red;'>
        <?= $this->params[0]->region?>
    </div>
    <div style = 'font-size: 400%; color:white'>
        ТВОИ КООРДИНАТЫ:
    </div>
    <div style = 'font-size: 400%; color:red'>
        ШИРОТА:<?= $this->params[0]->latitude?>
    </div>
    <div style = 'font-size: 400%; color:red'>
        ДОЛГОТА:<?= $this->params[0]->longitude?> 
    </div>

</div>
</body>