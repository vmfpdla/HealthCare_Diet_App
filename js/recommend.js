	<!--
		function SetDisplay(frm) {

			var set = frm.selectset.selectedIndex;

			switch( set ){
				case 0:
				frm.set.value = '칼로리에 맞는 Set가 표시됩니다.';
				break;
				case 1:
				frm.set.value = 'Set1';
				break;
				case 2:
				frm.set.value = 'Set2';
				break;
				case 3:
				frm.set.value = 'Set3';
			}

			return true;
		}
//-->

function Display(){
	document.getElementById("setKcal").style.display='block';
}