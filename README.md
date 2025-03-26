# cuckoo-alarm-watch
추억의 뻐꾸기 알람시계 (그누보드용)


컴 작업하다가 약속시간을 까먹은 적이 있어 한번 만들어봤습니다.

 

추억의 뻐꾸기 알람시계 (그누보드용)

매시간마다 울리고 따로 알람설정을 할 수 있는 아날로그 시계인데 알람에 맞쳐 뻐꾸기가 문열고 나와서 짖어댑니다.

데스크탑/모빌 겸용입니다.

설정된 알람은 db없이 localstorage에저장되어 delete하기 전까지 계속 유효합니다. 

 

cuckoo.php <--root에 copy

cuckoo.mp3 <-- root/files/ 에 copy, 무시하고 root에 그냥 copy하실려면 cuckoo.php에서 mp3 경로 재설정 필요

이렇게하고 실행형으로 그때그때마다 불러오시길 원하시면 그누보드에서 cuckoo.php를 불러오시면 됩니다.

 

만일, 항상 쓰기를 원하시면 아래코드를 aside 가장 밑부분에 붙여서 사용하시면 되고 style은 본인 aside에 맞춰서 수정하시면 됩니다.

<!-- cuckoo clock -->
        <div style="height: 75%; max-height: 100px; transform: scale(0.75); transform-origin: top right; text-align: right; float: right; margin-bottom: 600px;">
            <?php include(G5_PATH.'/cuckoo.php'); // 뻐꾸기 알람 시계 ?>
        </div>
<!-- cuckoo clock -->
 
