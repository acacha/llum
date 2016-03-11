<?php

// Insert content in line 159 using sed
// sed '159i\        App\\Providers' app.php

//Search lines with closing array symbol ]
//sed -n "/]/=" app.php

//  Search lines of providers array
//sed -n "/'providers'/=" app.php

//LINE=$(sed -n "/'providers'/=" app.php);sed -n ${LINE},\$p app.php

//LINE=$(sed -n "/'providers'/=" app.php);NLINE=$(sed -n ${LINE},\$p app.php | sed -n "/]/{=;q};");expr $LINE + $NLINE

//LINE=$(sed -n "/'providers'/=" app.php);NLINE=$(sed -n ${LINE},\$p app.php | sed -n "/]/{=;q};");echo $(($LINE + $NLINE -1))

function closest($array, $number) {

    sort($array);
    foreach ($array as $a) {
        if ($a >= $number) return $a;
    }
    return end($array); // or return NULL;
}
