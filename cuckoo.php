<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/common.php');
$g5['title'] = "Cuckoo Alarm Clock";
include_once(G5_PATH.'/_head.php');
if (!defined('_GNUBOARD_')) exit;
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<div class="cuckoo-clock">
    <div class="clock-face">
        <div class="clock-title">뻐꾸기 알람 시계</div>
        <div class="clock-title1">오리엔트</div>
        <div class="door"></div>
        <div class="bird"><i class="fas fa-dove"></i></div>
        <div class="hand hour-hand"></div>
        <div class="hand minute-hand"></div>
        <div class="hand second-hand"></div>
        <div class="center-dot"></div>
        <div class="numbers">
            <?php for($i = 1; $i <= 12; $i++): ?>
                <div class="number number<?php echo $i; ?>"><?php echo $i; ?></div>
            <?php endfor; ?>
        </div>
    </div>
    <div class="pendulum-case">
        <div class="pendulum">
            <div class="pendulum-stick"></div>
            <div class="pendulum-bob"></div>
        </div>
    </div>    
</div>

<!-- Add alarm settings form -->
<div class="alarm-settings">
    <h3>Alarm Settings</h3>
    <div class="alarm-input">
        <input type="time" id="alarmTime" class="form-control">
        <button onclick="setAlarm()" class="btn btn-primary">Set Alarm</button>
    </div>
    <div id="activeAlarms"></div>
</div>


<style>
.cuckoo-clock {
    margin-top: 2px;
    width: 300px;
    height: 300px;
    margin: 50px auto;
    position: relative;
    /* 전체 시계에 3D 효과 추가 */
    perspective: 1000px;
    transform-style: preserve-3d;
}

.clock-face {
    width: 100%;
    height: 100%;
    border: 10px solid #8B4513;
    border-radius: 50%;
    position: relative;
    background: #FFF;
    /* 나무 질감 효과 */
    background-image: 
        repeating-linear-gradient(45deg, rgba(139,69,19,0.1) 0px, rgba(139,69,19,0.1) 2px,
        transparent 2px, transparent 4px),
        linear-gradient(to bottom, #f4e4bc, #e6d5b8);
    box-shadow: 
        inset 0 0 50px rgba(0,0,0,0.2),
        0 10px 20px rgba(0,0,0,0.3);
}

/* 시계 테두리에 나무 장식 추가 */
.clock-face::before {
    content: '';
    position: absolute;
    top: -30px;
    left: -30px;
    right: -30px;
    bottom: -30px;
    border-radius: 50%;
    z-index: -1;
    background: linear-gradient(45deg, #8B4513, #A0522D);
    box-shadow: 
        inset 0 0 20px rgba(0,0,0,0.5),
        0 5px 15px rgba(0,0,0,0.2);
}

.clock-title {
    position: absolute;
    width: 100%;
    text-align: center;
    top: 65%;
    font-size: 18px;
    font-weight: bold;
    color: #8B4513;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
    z-index: 1;
}

.clock-title1 {
    position: absolute;
    width: 100%;
    text-align: center;
    top: 55%;
    font-size: 14px;
    font-weight: bold;
    color: #8B4513;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
    z-index: 1;
}

.hand {
    position: absolute;
    bottom: 50%;
    left: 50%;
    transform-origin: bottom;
    background: #000;
    box-shadow: 0 0 5px rgba(0,0,0,0.3);
    border-radius: 5px;
}

.hour-hand {
    width: 4px;
    height: 25%;
    background: #000;
}

.minute-hand {
    width: 3px;
    height: 35%;
    background: #000;
}

.second-hand {
    width: 2px;
    height: 40%;
    background: #f00;
}

.center-dot {
    width: 10px;
    height: 10px;
    background: #000;
    border-radius: 50%;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.door {
    width: 60px;
    height: 80px;
    background: linear-gradient(45deg, #5c3a21, #8B4513);
    position: absolute;
    top: 15%;
    left: 50%;
    transform: translateX(-50%);
    transform-origin: top;
    transition: transform 0.5s;
    border: 3px solid #4a3520;
    border-radius: 5px;
    box-shadow: 
        inset 0 0 15px rgba(0,0,0,0.4),
        0 5px 10px rgba(0,0,0,0.2);
    /* 나무 문양 효과 */
    background-image: 
        linear-gradient(90deg, rgba(92,58,33,0.5) 1px, transparent 1px),
        linear-gradient(0deg, rgba(92,58,33,0.5) 1px, transparent 1px);
    background-size: 10px 10px;
}

.bird {
    width: 30px;
    height: 40px;
    position: absolute;
    top: 25%;
    left: 50%;
    transform: translateX(-50%);
    display: none;
    text-align: center;
}

.bird i {
    font-size: 30px;
    color: #4a4a4a;
    display: inline-block;  /* 추가 */
    animation: birdMove 0.5s infinite alternate ease-in-out;  /* ease-in-out 추가 */
}

@keyframes birdMove {
    0% {
        transform: translateY(0) scale(1);
    }
    100% {
        transform: translateY(-5px) scale(4);
    }
}

.numbers {
    position: relative;
    height: 100%;
}

.number {
    position: absolute;
    width: 20px;
    height: 20px;
    text-align: center;
    font-size: 20px;
    font-weight: bold;
    transform-origin: center;
}

.alarm-settings h3 {
    font-size: 24px;
    font-weight: 700;
    color: #8B4513;
    text-transform: uppercase;
    margin-top: 150px;
    margin-bottom: 15px;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
    letter-spacing: 1px;
}

.alarm-settings {
    width: 300px;
    margin: 20px auto;
    text-align: center;
    position: relative; 
    z-index: 1000;
    margin-bottom: 100px;
}

.alarm-input {
    display: flex;
    gap: 10px;
    margin: 10px 0;
    justify-content: center;  /* 중앙 정렬 추가 */
    position: relative;
    z-index: 1000;
}

.form-control {
    padding: 8px;
    border: 1px solid #ced4da;
    border-radius: 4px;
    width: 150px;
}

.alarm-list {
    margin-top: 10px;
    width: 100%;  /* 전체 너비 사용 */ 
    margin-bottom: 50px;  /* 추가 */
    position: relative;   /* 추가 */
    z-index: 1000;       /* 추가 */   
}

.alarm-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 5px;
    margin: 5px 0;
    background: #f5f5f5;
    border-radius: 4px;    
}

.btn-primary {
    padding: 8px 15px;
    background-color: #8B4513;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    position: relative;
    z-index: 1000;
    min-width: 100px;     
    text-align: center;
    display: flex;           /* 추가 */
    align-items: center;     /* 추가 */
    justify-content: center; /* 추가 */
    height: 38px; 
    white-space: nowrap;  /* 추가: 텍스트가 줄바꿈되지 않도록 설정 */ 
}

.btn-primary:hover {
    background-color: #0056b3;
}

.pendulum-case {
    position: absolute;
    bottom: -150px;
    left: 50%;
    transform: translateX(-50%);
    width: 40px;
    height: 150px;
    background: linear-gradient(45deg, #8B4513, #A0522D);
    border: 3px solid #4a3520;
    border-radius: 0 0 20px 20px;
    box-shadow: inset 0 0 15px rgba(0,0,0,0.4);
}

.pendulum {
    position: absolute;
    left: 50%;
    top: 10px;
    transform-origin: top;
    animation: swing 2s infinite ease-in-out;
}

.pendulum-stick {
    width: 4px;
    height: 120px;
    background: #4a3520;
    margin-left: -2px;
    box-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.pendulum-bob {
    width: 30px;
    height: 30px;
    background: radial-gradient(circle at 30% 30%, #DAA520, #8B4513);
    border-radius: 50%;
    position: absolute;
    bottom: -15px;
    left: -13px;
    box-shadow: 
        inset 2px 2px 4px rgba(255,255,255,0.3),
        inset -2px -2px 4px rgba(0,0,0,0.5),
        2px 2px 4px rgba(0,0,0,0.3);
}

@keyframes swing {
    0%, 100% {
        transform: rotate(-8deg);
    }
    50% {
        transform: rotate(8deg);
    }
}

<?php for($i = 1; $i <= 12; $i++): ?>
.number<?php echo $i; ?> {
    left: calc(50% + 110px * <?php echo sin($i * 30 * M_PI / 180); ?>);
    top: calc(50% - 110px * <?php echo cos($i * 30 * M_PI / 180); ?>);
    transform: translate(-50%, -50%);
}
<?php endfor; ?>
</style>

<script>
let alarms = [];


// Load saved alarms when page loads
document.addEventListener('DOMContentLoaded', () => {
    const savedAlarms = localStorage.getItem('cuckooAlarms');
    if (savedAlarms) {
        alarms = JSON.parse(savedAlarms);
        updateAlarmsList();
    }
});

function setAlarm() {
    const alarmTime = document.getElementById('alarmTime').value;
    if (!alarmTime) {
        alert('Please select a time for the alarm');
        return;
    }
    
    if (alarms.includes(alarmTime)) {
        alert('This alarm time already exists');
        return;
    }
    
    alarms.push(alarmTime);
    localStorage.setItem('cuckooAlarms', JSON.stringify(alarms));
    updateAlarmsList();
    document.getElementById('alarmTime').value = '';
}


function updateAlarmsList() {
    const alarmsDiv = document.getElementById('activeAlarms');
    alarmsDiv.innerHTML = '<div class="alarm-list">';
    alarms.forEach((alarm, index) => {
        alarmsDiv.innerHTML += `
            <div class="alarm-item">
                <span>${alarm}</span>
                <button onclick="deleteAlarm(${index})" class="btn btn-danger btn-sm">Delete</button>
            </div>
        `;
    });
    alarmsDiv.innerHTML += '</div>';
}

function deleteAlarm(index) {
    alarms.splice(index, 1);
    localStorage.setItem('cuckooAlarms', JSON.stringify(alarms)); // localStorage 업데이트 추가
    updateAlarmsList();
}

function setClock() {
    const now = new Date();
    const seconds = now.getSeconds();
    const minutes = now.getMinutes();
    const hours = now.getHours() % 12;

    const secondDeg = (seconds / 60) * 360;
    const minuteDeg = ((minutes + seconds/60) / 60) * 360;
    const hourDeg = ((hours + minutes/60) / 12) * 360;

    document.querySelector('.second-hand').style.transform = `rotate(${secondDeg}deg)`;
    document.querySelector('.minute-hand').style.transform = `rotate(${minuteDeg}deg)`;
    document.querySelector('.hour-hand').style.transform = `rotate(${hourDeg}deg)`;

    // Check for alarms
    const currentTime = `${String(now.getHours()).padStart(2, '0')}:${String(minutes).padStart(2, '0')}`;
    if (alarms.includes(currentTime) && seconds === 0) {
        cuckoo();
    }
    
    // 정각일 때 뻐꾸기 애니메이션
    if(minutes === 0 && seconds === 0) {
        cuckoo();
    }
}

function cuckoo() {
    const door = document.querySelector('.door');
    const bird = document.querySelector('.bird');
    const audio = new Audio('<?php echo G5_URL; ?>/files/cuckoo.mp3');   
       
    // 뻐꾸기 소리 재생
    // 오디오 로드 완료 후 실행
    audio.addEventListener('canplaythrough', () => {
        door.style.transform = 'translateX(-50%) rotateX(90deg)';
        bird.style.display = 'block';
        audio.play();
    });
    
    // 오디오 종료 시 실행
    audio.addEventListener('ended', () => {
        door.style.transform = 'translateX(-50%) rotateX(0deg)';
        bird.style.display = 'none';
    });
}

setInterval(setClock, 1000);
setClock();
</script>

<?php
include_once(G5_PATH.'/tail.php');
?>