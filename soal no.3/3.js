let enter = "\n";

function segitiga (x){
    for (let i = 0; i < x; i++) {
        for (let spasi = 0; spasi < i; spasi++) {
            enter = enter + " ";
            
        }
        for (let j = x; j > i; j--) {
           enter = enter + " *";
            
        }
        enter = enter + "\n"
        
    }
    return enter;
}
console.log(segitiga(5));

// let hasil = "";
// let semua = 5;
// for (let i = 0; i < semua ; i++) {
//     for (let j = 0; j < i; j++) {
//        hasil = hasil + " ";
        
//     }
//     for (let k = semua ; k > i; k--) {
//        hasil = hasil + " *";
       
//     }
//     hasil = hasil + "\n";
    
// }
// console.log(hasil);