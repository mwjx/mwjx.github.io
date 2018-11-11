function processForm(form,number){
var totalx=0;
var totaly=0;
var roll_call=number;

scorex=new Array(roll_call);
scorey=new Array(roll_call);
check=new Array(roll_call);

for (i=roll_call;i>0;i--)
{scorex[i-1]=0
scorey[i-1]=0
check[i-1]=0};
//loops through the radio buttons finding out which one is selected

if (form.c1[0].checked==1) {scorex[0]=0.5; scorey[0]=0; check[0]=1;}
if (form.c1[1].checked==1) {scorex[0]=0.25; scorey[0]=0; check[0]=1;}
if (form.c1[2].checked==1) {scorex[0]=-0.375; scorey[0]=0; check[0]=1;}
if (form.c1[3].checked==1) {scorex[0]=-0.625; scorey[0]=0; check[0]=1;}
if (form.c2[0].checked==1) {scorex[1]=0; scorey[1]=-0.26; check[1]=1;}
if (form.c2[1].checked==1) {scorex[1]=0; scorey[1]=-0.155; check[1]=1;}
if (form.c2[2].checked==1) {scorex[1]=0; scorey[1]=0.15; check[1]=1;}
if (form.c2[3].checked==1) {scorex[1]=0; scorey[1]=0.255; check[1]=1;}
if (form.c3[0].checked==1) {scorex[2]=0; scorey[2]=0.23; check[2]=1;}
if (form.c3[1].checked==1) {scorex[2]=0; scorey[2]=0.13; check[2]=1;}
if (form.c3[2].checked==1) {scorex[2]=0; scorey[2]=-0.13; check[2]=1;}
if (form.c3[3].checked==1) {scorex[2]=0; scorey[2]=-0.23; check[2]=1;}
if (form.c4[0].checked==1) {scorex[3]=0; scorey[3]=-0.23; check[3]=1;}
if (form.c4[1].checked==1) {scorex[3]=0; scorey[3]=-0.13; check[3]=1;}
if (form.c4[2].checked==1) {scorex[3]=0; scorey[3]=0.13; check[3]=1;}
if (form.c4[3].checked==1) {scorex[3]=0; scorey[3]=0.23; check[3]=1;}
if (form.c5[0].checked==1) {scorex[4]=0; scorey[4]=-0.23; check[4]=1;}
if (form.c5[1].checked==1) {scorex[4]=0; scorey[4]=-0.13; check[4]=1;}
if (form.c5[2].checked==1) {scorex[4]=0; scorey[4]=0.13; check[4]=1;}
if (form.c5[3].checked==1) {scorex[4]=0; scorey[4]=0.23; check[4]=1;}
if (form.c6[0].checked==1) {scorex[5]=0; scorey[5]=-0.2; check[5]=1;}
if (form.c6[1].checked==1) {scorex[5]=0; scorey[5]=-0.1; check[5]=1;}
if (form.c6[2].checked==1) {scorex[5]=0; scorey[5]=0.11; check[5]=1;}
if (form.c6[3].checked==1) {scorex[5]=0; scorey[5]=0.21; check[5]=1;}
if (form.c7[0].checked==1) {scorex[6]=0; scorey[6]=0.23; check[6]=1;}
if (form.c7[1].checked==1) {scorex[6]=0; scorey[6]=0.13; check[6]=1;}
if (form.c7[2].checked==1) {scorex[6]=0; scorey[6]=-0.13; check[6]=1;}
if (form.c7[3].checked==1) {scorex[6]=0; scorey[6]=-0.23; check[6]=1;}
if (form.c8[0].checked==1) {scorex[7]=0.5; scorey[7]=0; check[7]=1;}
if (form.c8[1].checked==1) {scorex[7]=0.25; scorey[7]=0; check[7]=1;}
if (form.c8[2].checked==1) {scorex[7]=-0.375; scorey[7]=0; check[7]=1;}
if (form.c8[3].checked==1) {scorex[7]=-0.625; scorey[7]=0; check[7]=1;}
if (form.c9[0].checked==1) {scorex[8]=-0.5; scorey[8]=0; check[8]=1;}
if (form.c9[1].checked==1) {scorex[8]=-0.25; scorey[8]=0; check[8]=1;}
if (form.c9[2].checked==1) {scorex[8]=0.375; scorey[8]=0; check[8]=1;}
if (form.c9[3].checked==1) {scorex[8]=0.625; scorey[8]=0; check[8]=1;}
if (form.c10[0].checked==1) {scorex[9]=0.5; scorey[9]=0; check[9]=1;}
if (form.c10[1].checked==1) {scorex[9]=0.25; scorey[9]=0; check[9]=1;}
if (form.c10[2].checked==1) {scorex[9]=-0.25; scorey[9]=0; check[9]=1;}
if (form.c10[3].checked==1) {scorex[9]=-0.5; scorey[9]=0; check[9]=1;}
if (form.c11[0].checked==1) {scorex[10]=0.5; scorey[10]=0; check[10]=1;}
if (form.c11[1].checked==1) {scorex[10]=0.25; scorey[10]=0; check[10]=1;}
if (form.c11[2].checked==1) {scorex[10]=-0.375; scorey[10]=0; check[10]=1;}
if (form.c11[3].checked==1) {scorex[10]=-0.625; scorey[10]=0; check[10]=1;}
if (form.c12[0].checked==1) {scorex[11]=0.5; scorey[11]=0; check[11]=1;}
if (form.c12[1].checked==1) {scorex[11]=0.25; scorey[11]=0; check[11]=1;}
if (form.c12[2].checked==1) {scorex[11]=-0.5; scorey[11]=0; check[11]=1;}
if (form.c12[3].checked==1) {scorex[11]=-0.75; scorey[11]=0; check[11]=1;}
if (form.c13[0].checked==1) {scorex[12]=0.5; scorey[12]=0; check[12]=1;}
if (form.c13[1].checked==1) {scorex[12]=0.25; scorey[12]=0; check[12]=1;}
if (form.c13[2].checked==1) {scorex[12]=-0.5; scorey[12]=0; check[12]=1;}
if (form.c13[3].checked==1) {scorex[12]=-0.75; scorey[12]=0; check[12]=1;}
if (form.c14[0].checked==1) {scorex[13]=0.5; scorey[13]=0; check[13]=1;}
if (form.c14[1].checked==1) {scorex[13]=0.25; scorey[13]=0; check[13]=1;}
if (form.c14[2].checked==1) {scorex[13]=-0.375; scorey[13]=0; check[13]=1;}
if (form.c14[3].checked==1) {scorex[13]=-0.625; scorey[13]=0; check[13]=1;}
if (form.c15[0].checked==1) {scorex[14]=0.5; scorey[14]=0; check[14]=1;}
if (form.c15[1].checked==1) {scorex[14]=0.25; scorey[14]=0; check[14]=1;}
if (form.c15[2].checked==1) {scorex[14]=-0.5; scorey[14]=0; check[14]=1;}
if (form.c15[3].checked==1) {scorex[14]=-0.625; scorey[14]=0; check[14]=1;}
if (form.c16[0].checked==1) {scorex[15]=-0.5; scorey[15]=0; check[15]=1;}
if (form.c16[1].checked==1) {scorex[15]=-0.25; scorey[15]=0; check[15]=1;}
if (form.c16[2].checked==1) {scorex[15]=0.375; scorey[15]=0; check[15]=1;}
if (form.c16[3].checked==1) {scorex[15]=0.625; scorey[15]=0; check[15]=1;}
if (form.c17[0].checked==1) {scorex[16]=-0.5; scorey[16]=0; check[16]=1;}
if (form.c17[1].checked==1) {scorex[16]=-0.25; scorey[16]=0; check[16]=1;}
if (form.c17[2].checked==1) {scorex[16]=0.375; scorey[16]=0; check[16]=1;}
if (form.c17[3].checked==1) {scorex[16]=0.5; scorey[16]=0; check[16]=1;}
if (form.c18[0].checked==1) {scorex[17]=-0.5; scorey[17]=0; check[17]=1;}
if (form.c18[1].checked==1) {scorex[17]=-0.25; scorey[17]=0; check[17]=1;}
if (form.c18[2].checked==1) {scorex[17]=0.25; scorey[17]=0; check[17]=1;}
if (form.c18[3].checked==1) {scorex[17]=0.5; scorey[17]=0; check[17]=1;}
if (form.c19[0].checked==1) {scorex[18]=0.5; scorey[18]=0; check[18]=1;}
if (form.c19[1].checked==1) {scorex[18]=0.25; scorey[18]=0; check[18]=1;}
if (form.c19[2].checked==1) {scorex[18]=-0.25; scorey[18]=0; check[18]=1;}
if (form.c19[3].checked==1) {scorex[18]=-0.375; scorey[18]=0; check[18]=1;}
if (form.c20[0].checked==1) {scorex[19]=0; scorey[19]=0; check[19]=1;}
if (form.c20[1].checked==1) {scorex[19]=0; scorey[19]=0; check[19]=1;}
if (form.c20[2].checked==1) {scorex[19]=0; scorey[19]=0; check[19]=1;}
if (form.c20[3].checked==1) {scorex[19]=0; scorey[19]=0; check[19]=1;}
if (form.c21[0].checked==1) {scorex[20]=-0.5; scorey[20]=0; check[20]=1;}
if (form.c21[1].checked==1) {scorex[20]=-0.25; scorey[20]=0; check[20]=1;}
if (form.c21[2].checked==1) {scorex[20]=0.5; scorey[20]=0; check[20]=1;}
if (form.c21[3].checked==1) {scorex[20]=0.75; scorey[20]=0; check[20]=1;}
if (form.c22[0].checked==1) {scorex[21]=0; scorey[21]=-0.2; check[21]=1;}
if (form.c22[1].checked==1) {scorex[21]=0; scorey[21]=-0.1; check[21]=1;}
if (form.c22[2].checked==1) {scorex[21]=0; scorey[21]=0.11; check[21]=1;}
if (form.c22[3].checked==1) {scorex[21]=0; scorey[21]=0.21; check[21]=1;}
if (form.c23[0].checked==1) {scorex[22]=0; scorey[22]=0.23; check[22]=1;}
if (form.c23[1].checked==1) {scorex[22]=0; scorey[22]=0.175; check[22]=1;}
if (form.c23[2].checked==1) {scorex[22]=0; scorey[22]=-0.13; check[22]=1;}
if (form.c23[3].checked==1) {scorex[22]=0; scorey[22]=-0.23; check[22]=1;}
if (form.c24[0].checked==1) {scorex[23]=0; scorey[23]=-0.18; check[23]=1;}
if (form.c24[1].checked==1) {scorex[23]=0; scorey[23]=-0.125; check[23]=1;}
if (form.c24[2].checked==1) {scorex[23]=0; scorey[23]=0.08; check[23]=1;}
if (form.c24[3].checked==1) {scorex[23]=0; scorey[23]=0.18; check[23]=1;}
if (form.c25[0].checked==1) {scorex[24]=-0.5; scorey[24]=0; check[24]=1;}
if (form.c25[1].checked==1) {scorex[24]=-0.25; scorey[24]=0; check[24]=1;}
if (form.c25[2].checked==1) {scorex[24]=0.5; scorey[24]=0; check[24]=1;}
if (form.c25[3].checked==1) {scorex[24]=0.625; scorey[24]=0; check[24]=1;}
if (form.c26[0].checked==1) {scorex[25]=0; scorey[25]=0.26; check[25]=1;}
if (form.c26[1].checked==1) {scorex[25]=0; scorey[25]=0.055; check[25]=1;}
if (form.c26[2].checked==1) {scorex[25]=0; scorey[25]=-0.15; check[25]=1;}
if (form.c26[3].checked==1) {scorex[25]=0; scorey[25]=-0.255; check[25]=1;}
if (form.c27[0].checked==1) {scorex[26]=0; scorey[26]=-0.23; check[26]=1;}
if (form.c27[1].checked==1) {scorex[26]=0; scorey[26]=-0.13; check[26]=1;}
if (form.c27[2].checked==1) {scorex[26]=0; scorey[26]=0.13; check[26]=1;}
if (form.c27[3].checked==1) {scorex[26]=0; scorey[26]=0.23; check[26]=1;}
if (form.c28[0].checked==1) {scorex[27]=0; scorey[27]=-0.26; check[27]=1;}
if (form.c28[1].checked==1) {scorex[27]=0; scorey[27]=-0.155; check[27]=1;}
if (form.c28[2].checked==1) {scorex[27]=0; scorey[27]=0.1; check[27]=1;}
if (form.c28[3].checked==1) {scorex[27]=0; scorey[27]=0.255; check[27]=1;}
if (form.c29[0].checked==1) {scorex[28]=0; scorey[28]=0.23; check[28]=1;}
if (form.c29[1].checked==1) {scorex[28]=0; scorey[28]=0.13; check[28]=1;}
if (form.c29[2].checked==1) {scorex[28]=0; scorey[28]=-0.08; check[28]=1;}
if (form.c29[3].checked==1) {scorex[28]=0; scorey[28]=-0.23; check[28]=1;}
if (form.c30[0].checked==1) {scorex[29]=0; scorey[29]=0.2; check[29]=1;}
if (form.c30[1].checked==1) {scorex[29]=0; scorey[29]=0.045; check[29]=1;}
if (form.c30[2].checked==1) {scorex[29]=0; scorey[29]=-0.11; check[29]=1;}
if (form.c30[3].checked==1) {scorex[29]=0; scorey[29]=-0.21; check[29]=1;}
if (form.c31[0].checked==1) {scorex[30]=0; scorey[30]=-0.26; check[30]=1;}
if (form.c31[1].checked==1) {scorex[30]=0; scorey[30]=-0.155; check[30]=1;}
if (form.c31[2].checked==1) {scorex[30]=0; scorey[30]=0.1; check[30]=1;}
if (form.c31[3].checked==1) {scorex[30]=0; scorey[30]=0.255; check[30]=1;}
if (form.c32[0].checked==1) {scorex[31]=0; scorey[31]=-0.29; check[31]=1;}
if (form.c32[1].checked==1) {scorex[31]=0; scorey[31]=-0.185; check[31]=1;}
if (form.c32[2].checked==1) {scorex[31]=0; scorey[31]=0.17; check[31]=1;}
if (form.c32[3].checked==1) {scorex[31]=0; scorey[31]=0.275; check[31]=1;}
if (form.c33[0].checked==1) {scorex[32]=0; scorey[32]=-0.26; check[32]=1;}
if (form.c33[1].checked==1) {scorex[32]=0; scorey[32]=-0.155; check[32]=1;}
if (form.c33[2].checked==1) {scorex[32]=0; scorey[32]=0.15; check[32]=1;}
if (form.c33[3].checked==1) {scorex[32]=0; scorey[32]=0.255; check[32]=1;}
if (form.c34[0].checked==1) {scorex[33]=0; scorey[33]=0.23; check[33]=1;}
if (form.c34[1].checked==1) {scorex[33]=0; scorey[33]=0.175; check[33]=1;}
if (form.c34[2].checked==1) {scorex[33]=0; scorey[33]=-0.13; check[33]=1;}
if (form.c34[3].checked==1) {scorex[33]=0; scorey[33]=-0.23; check[33]=1;}
if (form.c35[0].checked==1) {scorex[34]=0; scorey[34]=-0.23; check[34]=1;}
if (form.c35[1].checked==1) {scorex[34]=0; scorey[34]=-0.13; check[34]=1;}
if (form.c35[2].checked==1) {scorex[34]=0; scorey[34]=0.13; check[34]=1;}
if (form.c35[3].checked==1) {scorex[34]=0; scorey[34]=0.23; check[34]=1;}
if (form.c36[0].checked==1) {scorex[35]=0; scorey[35]=-0.2; check[35]=1;}
if (form.c36[1].checked==1) {scorex[35]=0; scorey[35]=-0.1; check[35]=1;}
if (form.c36[2].checked==1) {scorex[35]=0; scorey[35]=0.11; check[35]=1;}
if (form.c36[3].checked==1) {scorex[35]=0; scorey[35]=0.21; check[35]=1;}
if (form.c37[0].checked==1) {scorex[36]=0; scorey[36]=-0.23; check[36]=1;}
if (form.c37[1].checked==1) {scorex[36]=0; scorey[36]=-0.075; check[36]=1;}
if (form.c37[2].checked==1) {scorex[36]=0; scorey[36]=0.13; check[36]=1;}
if (form.c37[3].checked==1) {scorex[36]=0; scorey[36]=0.23; check[36]=1;}
if (form.c38[0].checked==1) {scorex[37]=-0.5; scorey[37]=0; check[37]=1;}
if (form.c38[1].checked==1) {scorex[37]=-0.25; scorey[37]=0; check[37]=1;}
if (form.c38[2].checked==1) {scorex[37]=0.75; scorey[37]=0; check[37]=1;}
if (form.c38[3].checked==1) {scorex[37]=0.875; scorey[37]=0; check[37]=1;}
if (form.c39[0].checked==1) {scorex[38]=-0.5; scorey[38]=0; check[38]=1;}
if (form.c39[1].checked==1) {scorex[38]=-0.375; scorey[38]=0; check[38]=1;}
if (form.c39[2].checked==1) {scorex[38]=0.125; scorey[38]=0; check[38]=1;}
if (form.c39[3].checked==1) {scorex[38]=0.25; scorey[38]=0; check[38]=1;}
if (form.c40[0].checked==1) {scorex[39]=0; scorey[39]=0.26; check[39]=1;}
if (form.c40[1].checked==1) {scorex[39]=0; scorey[39]=0.155; check[39]=1;}
if (form.c40[2].checked==1) {scorex[39]=0; scorey[39]=-0.1; check[39]=1;}
if (form.c40[3].checked==1) {scorex[39]=0; scorey[39]=-0.255; check[39]=1;}
if (form.c41[0].checked==1) {scorex[40]=0; scorey[40]=-0.29; check[40]=1;}
if (form.c41[1].checked==1) {scorex[40]=0; scorey[40]=-0.135; check[40]=1;}
if (form.c41[2].checked==1) {scorex[40]=0; scorey[40]=0.17; check[40]=1;}
if (form.c41[3].checked==1) {scorex[40]=0; scorey[40]=0.275; check[40]=1;}
if (form.c42[0].checked==1) {scorex[41]=0; scorey[41]=-0.26; check[41]=1;}
if (form.c42[1].checked==1) {scorex[41]=0; scorey[41]=-0.155; check[41]=1;}
if (form.c42[2].checked==1) {scorex[41]=0; scorey[41]=0.15; check[41]=1;}
if (form.c42[3].checked==1) {scorex[41]=0; scorey[41]=0.255; check[41]=1;}
if (form.c43[0].checked==1) {scorex[42]=0; scorey[42]=-0.26; check[42]=1;}
if (form.c43[1].checked==1) {scorex[42]=0; scorey[42]=-0.155; check[42]=1;}
if (form.c43[2].checked==1) {scorex[42]=0; scorey[42]=0.15; check[42]=1;}
if (form.c43[3].checked==1) {scorex[42]=0; scorey[42]=0.255; check[42]=1;}
if (form.c44[0].checked==1) {scorex[43]=0; scorey[43]=-0.2; check[43]=1;}
if (form.c44[1].checked==1) {scorex[43]=0; scorey[43]=-0.1; check[43]=1;}
if (form.c44[2].checked==1) {scorex[43]=0; scorey[43]=0.11; check[43]=1;}
if (form.c44[3].checked==1) {scorex[43]=0; scorey[43]=0.21; check[43]=1;}
if (form.c45[0].checked==1) {scorex[44]=0; scorey[44]=-0.26; check[44]=1;}
if (form.c45[1].checked==1) {scorex[44]=0; scorey[44]=-0.155; check[44]=1;}
if (form.c45[2].checked==1) {scorex[44]=0; scorey[44]=0.15; check[44]=1;}
if (form.c45[3].checked==1) {scorex[44]=0; scorey[44]=0.255; check[44]=1;}
if (form.c46[0].checked==1) {scorex[45]=0; scorey[45]=-0.23; check[45]=1;}
if (form.c46[1].checked==1) {scorex[45]=0; scorey[45]=-0.13; check[45]=1;}
if (form.c46[2].checked==1) {scorex[45]=0; scorey[45]=0.13; check[45]=1;}
if (form.c46[3].checked==1) {scorex[45]=0; scorey[45]=0.23; check[45]=1;}
if (form.c47[0].checked==1) {scorex[46]=0; scorey[46]=-0.26; check[46]=1;}
if (form.c47[1].checked==1) {scorex[46]=0; scorey[46]=-0.155; check[46]=1;}
if (form.c47[2].checked==1) {scorex[46]=0; scorey[46]=0.15; check[46]=1;}
if (form.c47[3].checked==1) {scorex[46]=0; scorey[46]=0.255; check[46]=1;}
if (form.c48[0].checked==1) {scorex[47]=0; scorey[47]=-0.18; check[47]=1;}
if (form.c48[1].checked==1) {scorex[47]=0; scorey[47]=-0.08; check[47]=1;}
if (form.c48[2].checked==1) {scorex[47]=0; scorey[47]=0.08; check[47]=1;}
if (form.c48[3].checked==1) {scorex[47]=0; scorey[47]=0.18; check[47]=1;}
if (form.c49[0].checked==1) {scorex[48]=0; scorey[48]=-0.23; check[48]=1;}
if (form.c49[1].checked==1) {scorex[48]=0; scorey[48]=-0.13; check[48]=1;}
if (form.c49[2].checked==1) {scorex[48]=0; scorey[48]=0.13; check[48]=1;}
if (form.c49[3].checked==1) {scorex[48]=0; scorey[48]=0.23; check[48]=1;}
if (form.c50[0].checked==1) {scorex[49]=0; scorey[49]=0.23; check[49]=1;}
if (form.c50[1].checked==1) {scorex[49]=0; scorey[49]=0.13; check[49]=1;}
if (form.c50[2].checked==1) {scorex[49]=0; scorey[49]=-0.13; check[49]=1;}
if (form.c50[3].checked==1) {scorex[49]=0; scorey[49]=-0.23; check[49]=1;}
if (form.c51[0].checked==1) {scorex[50]=0; scorey[50]=-0.2; check[50]=1;}
if (form.c51[1].checked==1) {scorex[50]=0; scorey[50]=-0.1; check[50]=1;}
if (form.c51[2].checked==1) {scorex[50]=0; scorey[50]=0.11; check[50]=1;}
if (form.c51[3].checked==1) {scorex[50]=0; scorey[50]=0.21; check[50]=1;}
if (form.c52[0].checked==1) {scorex[51]=0; scorey[51]=-0.23; check[51]=1;}
if (form.c52[1].checked==1) {scorex[51]=0; scorey[51]=-0.13; check[51]=1;}
if (form.c52[2].checked==1) {scorex[51]=0; scorey[51]=0.13; check[51]=1;}
if (form.c52[3].checked==1) {scorex[51]=0; scorey[51]=0.23; check[51]=1;}
if (form.c53[0].checked==1) {scorex[52]=0; scorey[52]=-0.2; check[52]=1;}
if (form.c53[1].checked==1) {scorex[52]=0; scorey[52]=-0.1; check[52]=1;}
if (form.c53[2].checked==1) {scorex[52]=0; scorey[52]=0.11; check[52]=1;}
if (form.c53[3].checked==1) {scorex[52]=0; scorey[52]=0.21; check[52]=1;}
if (form.c54[0].checked==1) {scorex[53]=-0.5; scorey[53]=0; check[53]=1;}
if (form.c54[1].checked==1) {scorex[53]=-0.375; scorey[53]=0; check[53]=1;}
if (form.c54[2].checked==1) {scorex[53]=0.625; scorey[53]=0; check[53]=1;}
if (form.c54[3].checked==1) {scorex[53]=0.75; scorey[53]=0; check[53]=1;}
if (form.c55[0].checked==1) {scorex[54]=0; scorey[54]=-0.23; check[54]=1;}
if (form.c55[1].checked==1) {scorex[54]=0; scorey[54]=-0.13; check[54]=1;}
if (form.c55[2].checked==1) {scorex[54]=0; scorey[54]=0.13; check[54]=1;}
if (form.c55[3].checked==1) {scorex[54]=0; scorey[54]=0.23; check[54]=1;}
if (form.c56[0].checked==1) {scorex[55]=0; scorey[55]=-0.2; check[55]=1;}
if (form.c56[1].checked==1) {scorex[55]=0; scorey[55]=-0.1; check[55]=1;}
if (form.c56[2].checked==1) {scorex[55]=0; scorey[55]=0.11; check[55]=1;}
if (form.c56[3].checked==1) {scorex[55]=0; scorey[55]=0.21; check[55]=1;}
if (form.c57[0].checked==1) {scorex[56]=0; scorey[56]=-0.23; check[56]=1;}
if (form.c57[1].checked==1) {scorex[56]=0; scorey[56]=-0.175; check[56]=1;}
if (form.c57[2].checked==1) {scorex[56]=0; scorey[56]=0.13; check[56]=1;}
if (form.c57[3].checked==1) {scorex[56]=0; scorey[56]=0.23; check[56]=1;}
if (form.c58[0].checked==1) {scorex[57]=0; scorey[57]=0.23; check[57]=1;}
if (form.c58[1].checked==1) {scorex[57]=0; scorey[57]=0.175; check[57]=1;}
if (form.c58[2].checked==1) {scorex[57]=0; scorey[57]=-0.13; check[57]=1;}
if (form.c58[3].checked==1) {scorex[57]=0; scorey[57]=-0.23; check[57]=1;}
if (form.c59[0].checked==1) {scorex[58]=0; scorey[58]=0.23; check[58]=1;}
if (form.c59[1].checked==1) {scorex[58]=0; scorey[58]=0.13; check[58]=1;}
if (form.c59[2].checked==1) {scorex[58]=0; scorey[58]=-0.13; check[58]=1;}
if (form.c59[3].checked==1) {scorex[58]=0; scorey[58]=-0.23; check[58]=1;}
if (form.c60[0].checked==1) {scorex[59]=0; scorey[59]=0.26; check[59]=1;}
if (form.c60[1].checked==1) {scorex[59]=0; scorey[59]=0.155; check[59]=1;}
if (form.c60[2].checked==1) {scorex[59]=0; scorey[59]=-0.15; check[59]=1;}
if (form.c60[3].checked==1) {scorex[59]=0; scorey[59]=-0.255; check[59]=1;}
if (form.c61[0].checked==1) {scorex[60]=0; scorey[60]=-0.26; check[60]=1;}
if (form.c61[1].checked==1) {scorex[60]=0; scorey[60]=-0.155; check[60]=1;}
if (form.c61[2].checked==1) {scorex[60]=0; scorey[60]=0.15; check[60]=1;}
if (form.c61[3].checked==1) {scorex[60]=0; scorey[60]=0.255; check[60]=1;}
if (form.c62[0].checked==1) {scorex[61]=0; scorey[61]=-0.2; check[61]=1;}
if (form.c62[1].checked==1) {scorex[61]=0; scorey[61]=-0.1; check[61]=1;}
if (form.c62[2].checked==1) {scorex[61]=0; scorey[61]=0.11; check[61]=1;}
if (form.c62[3].checked==1) {scorex[61]=0; scorey[61]=0.21; check[61]=1;}

for (i=roll_call;i>0;i--)
{
totalx+=scorex[i-1]
totaly+=scorey[i-1]
};    

totalx=Math.round(totalx*100)/100;
totaly=Math.round(totaly*100)/100;
form.answer.value="经济立场坐标（左翼<->右翼）"+totalx+"，政治立场坐标（专制<->自由）"+totaly;

for (i=roll_call;i>0;i--)
{
if (check[i-1]==0){form.answer.value="您需要回答第"+i+"题";}
};

}


function processForm_bdwm(form,number){
var totalx=0;
var totaly=0;
var totalz=0;
var roll_call=number;

scorex=new Array(roll_call);
scorey=new Array(roll_call);
scorez=new Array(roll_call);
check=new Array(roll_call);

for (i=roll_call;i>0;i--)
{scorex[i-1]=0
scorey[i-1]=0
scorez[i-1]=0
check[i-1]=0};

//loops through the radio buttons finding out which one is selected

if (form.c1[0].checked==1) {scorex[0]=2; scorey[0]=0; scorez[0]=0; check[0]=1;}
if (form.c1[1].checked==1) {scorex[0]=1; scorey[0]=0; scorez[0]=0; check[0]=1;}
if (form.c1[2].checked==1) {scorex[0]=-1; scorey[0]=0; scorez[0]=0; check[0]=1;}
if (form.c1[3].checked==1) {scorex[0]=-2; scorey[0]=0; scorez[0]=0; check[0]=1;}
if (form.c2[0].checked==1) {scorex[1]=0; scorey[1]=2; scorez[1]=0; check[1]=1;}
if (form.c2[1].checked==1) {scorex[1]=0; scorey[1]=1; scorez[1]=0; check[1]=1;}
if (form.c2[2].checked==1) {scorex[1]=0; scorey[1]=-1; scorez[1]=0; check[1]=1;}
if (form.c2[3].checked==1) {scorex[1]=0; scorey[1]=-2; scorez[1]=0; check[1]=1;}
if (form.c3[0].checked==1) {scorex[2]=-2; scorey[2]=0; scorez[2]=0; check[2]=1;}
if (form.c3[1].checked==1) {scorex[2]=-1; scorey[2]=0; scorez[2]=0; check[2]=1;}
if (form.c3[2].checked==1) {scorex[2]=1; scorey[2]=0; scorez[2]=0; check[2]=1;}
if (form.c3[3].checked==1) {scorex[2]=2; scorey[2]=0; scorez[2]=0; check[2]=1;}
if (form.c4[0].checked==1) {scorex[3]=0; scorey[3]=0; scorez[3]=-2; check[3]=1;}
if (form.c4[1].checked==1) {scorex[3]=0; scorey[3]=0; scorez[3]=-1; check[3]=1;}
if (form.c4[2].checked==1) {scorex[3]=0; scorey[3]=0; scorez[3]=1; check[3]=1;}
if (form.c4[3].checked==1) {scorex[3]=0; scorey[3]=0; scorez[3]=2; check[3]=1;}
if (form.c5[0].checked==1) {scorex[4]=0; scorey[4]=2; scorez[4]=0; check[4]=1;}
if (form.c5[1].checked==1) {scorex[4]=0; scorey[4]=1; scorez[4]=0; check[4]=1;}
if (form.c5[2].checked==1) {scorex[4]=0; scorey[4]=-1; scorez[4]=0; check[4]=1;}
if (form.c5[3].checked==1) {scorex[4]=0; scorey[4]=-2; scorez[4]=0; check[4]=1;}
if (form.c6[0].checked==1) {scorex[5]=-2; scorey[5]=0; scorez[5]=0; check[5]=1;}
if (form.c6[1].checked==1) {scorex[5]=-1; scorey[5]=0; scorez[5]=0; check[5]=1;}
if (form.c6[2].checked==1) {scorex[5]=1; scorey[5]=0; scorez[5]=0; check[5]=1;}
if (form.c6[3].checked==1) {scorex[5]=2; scorey[5]=0; scorez[5]=0; check[5]=1;}
if (form.c7[0].checked==1) {scorex[6]=0; scorey[6]=2; scorez[6]=0; check[6]=1;}
if (form.c7[1].checked==1) {scorex[6]=0; scorey[6]=1; scorez[6]=0; check[6]=1;}
if (form.c7[2].checked==1) {scorex[6]=0; scorey[6]=-1; scorez[6]=0; check[6]=1;}
if (form.c7[3].checked==1) {scorex[6]=0; scorey[6]=-2; scorez[6]=0; check[6]=1;}
if (form.c8[0].checked==1) {scorex[7]=2; scorey[7]=0; scorez[7]=0; check[7]=1;}
if (form.c8[1].checked==1) {scorex[7]=1; scorey[7]=0; scorez[7]=0; check[7]=1;}
if (form.c8[2].checked==1) {scorex[7]=-1; scorey[7]=0; scorez[7]=0; check[7]=1;}
if (form.c8[3].checked==1) {scorex[7]=-2; scorey[7]=0; scorez[7]=0; check[7]=1;}
if (form.c9[0].checked==1) {scorex[8]=0; scorey[8]=0; scorez[8]=2; check[8]=1;}
if (form.c9[1].checked==1) {scorex[8]=0; scorey[8]=0; scorez[8]=1; check[8]=1;}
if (form.c9[2].checked==1) {scorex[8]=0; scorey[8]=0; scorez[8]=-1; check[8]=1;}
if (form.c9[3].checked==1) {scorex[8]=0; scorey[8]=0; scorez[8]=-2; check[8]=1;}
if (form.c10[0].checked==1) {scorex[9]=0; scorey[9]=-2; scorez[9]=0; check[9]=1;}
if (form.c10[1].checked==1) {scorex[9]=0; scorey[9]=-1; scorez[9]=0; check[9]=1;}
if (form.c10[2].checked==1) {scorex[9]=0; scorey[9]=1; scorez[9]=0; check[9]=1;}
if (form.c10[3].checked==1) {scorex[9]=0; scorey[9]=2; scorez[9]=0; check[9]=1;}
if (form.c11[0].checked==1) {scorex[10]=2; scorey[10]=0; scorez[10]=0; check[10]=1;}
if (form.c11[1].checked==1) {scorex[10]=1; scorey[10]=0; scorez[10]=0; check[10]=1;}
if (form.c11[2].checked==1) {scorex[10]=-1; scorey[10]=0; scorez[10]=0; check[10]=1;}
if (form.c11[3].checked==1) {scorex[10]=-2; scorey[10]=0; scorez[10]=0; check[10]=1;}
if (form.c12[0].checked==1) {scorex[11]=0; scorey[11]=0; scorez[11]=2; check[11]=1;}
if (form.c12[1].checked==1) {scorex[11]=0; scorey[11]=0; scorez[11]=1; check[11]=1;}
if (form.c12[2].checked==1) {scorex[11]=0; scorey[11]=0; scorez[11]=-1; check[11]=1;}
if (form.c12[3].checked==1) {scorex[11]=0; scorey[11]=0; scorez[11]=-2; check[11]=1;}
if (form.c13[0].checked==1) {scorex[12]=0; scorey[12]=2; scorez[12]=0; check[12]=1;}
if (form.c13[1].checked==1) {scorex[12]=0; scorey[12]=1; scorez[12]=0; check[12]=1;}
if (form.c13[2].checked==1) {scorex[12]=0; scorey[12]=-1; scorez[12]=0; check[12]=1;}
if (form.c13[3].checked==1) {scorex[12]=0; scorey[12]=-2; scorez[12]=0; check[12]=1;}
if (form.c14[0].checked==1) {scorex[13]=-2; scorey[13]=0; scorez[13]=0; check[13]=1;}
if (form.c14[1].checked==1) {scorex[13]=-1; scorey[13]=0; scorez[13]=0; check[13]=1;}
if (form.c14[2].checked==1) {scorex[13]=1; scorey[13]=0; scorez[13]=0; check[13]=1;}
if (form.c14[3].checked==1) {scorex[13]=2; scorey[13]=0; scorez[13]=0; check[13]=1;}
if (form.c15[0].checked==1) {scorex[14]=0; scorey[14]=2; scorez[14]=0; check[14]=1;}
if (form.c15[1].checked==1) {scorex[14]=0; scorey[14]=1; scorez[14]=0; check[14]=1;}
if (form.c15[2].checked==1) {scorex[14]=0; scorey[14]=-1; scorez[14]=0; check[14]=1;}
if (form.c15[3].checked==1) {scorex[14]=0; scorey[14]=-2; scorez[14]=0; check[14]=1;}
if (form.c16[0].checked==1) {scorex[15]=-2; scorey[15]=0; scorez[15]=0; check[15]=1;}
if (form.c16[1].checked==1) {scorex[15]=-1; scorey[15]=0; scorez[15]=0; check[15]=1;}
if (form.c16[2].checked==1) {scorex[15]=1; scorey[15]=0; scorez[15]=0; check[15]=1;}
if (form.c16[3].checked==1) {scorex[15]=2; scorey[15]=0; scorez[15]=0; check[15]=1;}
if (form.c17[0].checked==1) {scorex[16]=0; scorey[16]=0; scorez[16]=-2; check[16]=1;}
if (form.c17[1].checked==1) {scorex[16]=0; scorey[16]=0; scorez[16]=-1; check[16]=1;}
if (form.c17[2].checked==1) {scorex[16]=0; scorey[16]=0; scorez[16]=1; check[16]=1;}
if (form.c17[3].checked==1) {scorex[16]=0; scorey[16]=0; scorez[16]=2; check[16]=1;}
if (form.c18[0].checked==1) {scorex[17]=0; scorey[17]=2; scorez[17]=0; check[17]=1;}
if (form.c18[1].checked==1) {scorex[17]=0; scorey[17]=1; scorez[17]=0; check[17]=1;}
if (form.c18[2].checked==1) {scorex[17]=0; scorey[17]=-1; scorez[17]=0; check[17]=1;}
if (form.c18[3].checked==1) {scorex[17]=0; scorey[17]=-2; scorez[17]=0; check[17]=1;}
if (form.c19[0].checked==1) {scorex[18]=2; scorey[18]=0; scorez[18]=0; check[18]=1;}
if (form.c19[1].checked==1) {scorex[18]=1; scorey[18]=0; scorez[18]=0; check[18]=1;}
if (form.c19[2].checked==1) {scorex[18]=-1; scorey[18]=0; scorez[18]=0; check[18]=1;}
if (form.c19[3].checked==1) {scorex[18]=-2; scorey[18]=0; scorez[18]=0; check[18]=1;}
if (form.c20[0].checked==1) {scorex[19]=0; scorey[19]=2; scorez[19]=0; check[19]=1;}
if (form.c20[1].checked==1) {scorex[19]=0; scorey[19]=1; scorez[19]=0; check[19]=1;}
if (form.c20[2].checked==1) {scorex[19]=0; scorey[19]=-1; scorez[19]=0; check[19]=1;}
if (form.c20[3].checked==1) {scorex[19]=0; scorey[19]=-2; scorez[19]=0; check[19]=1;}
if (form.c21[0].checked==1) {scorex[20]=0; scorey[20]=-2; scorez[20]=0; check[20]=1;}
if (form.c21[1].checked==1) {scorex[20]=0; scorey[20]=-1; scorez[20]=0; check[20]=1;}
if (form.c21[2].checked==1) {scorex[20]=0; scorey[20]=1; scorez[20]=0; check[20]=1;}
if (form.c21[3].checked==1) {scorex[20]=0; scorey[20]=2; scorez[20]=0; check[20]=1;}
if (form.c22[0].checked==1) {scorex[21]=2; scorey[21]=0; scorez[21]=0; check[21]=1;}
if (form.c22[1].checked==1) {scorex[21]=1; scorey[21]=0; scorez[21]=0; check[21]=1;}
if (form.c22[2].checked==1) {scorex[21]=-1; scorey[21]=0; scorez[21]=0; check[21]=1;}
if (form.c22[3].checked==1) {scorex[21]=-2; scorey[21]=0; scorez[21]=0; check[21]=1;}
if (form.c23[0].checked==1) {scorex[22]=0; scorey[22]=2; scorez[22]=0; check[22]=1;}
if (form.c23[1].checked==1) {scorex[22]=0; scorey[22]=1; scorez[22]=0; check[22]=1;}
if (form.c23[2].checked==1) {scorex[22]=0; scorey[22]=-1; scorez[22]=0; check[22]=1;}
if (form.c23[3].checked==1) {scorex[22]=0; scorey[22]=-2; scorez[22]=0; check[22]=1;}
if (form.c24[0].checked==1) {scorex[23]=2; scorey[23]=0; scorez[23]=0; check[23]=1;}
if (form.c24[1].checked==1) {scorex[23]=1; scorey[23]=0; scorez[23]=0; check[23]=1;}
if (form.c24[2].checked==1) {scorex[23]=-1; scorey[23]=0; scorez[23]=0; check[23]=1;}
if (form.c24[3].checked==1) {scorex[23]=-2; scorey[23]=0; scorez[23]=0; check[23]=1;}
if (form.c25[0].checked==1) {scorex[24]=0; scorey[24]=0; scorez[24]=-2; check[24]=1;}
if (form.c25[1].checked==1) {scorex[24]=0; scorey[24]=0; scorez[24]=-1; check[24]=1;}
if (form.c25[2].checked==1) {scorex[24]=0; scorey[24]=0; scorez[24]=1; check[24]=1;}
if (form.c25[3].checked==1) {scorex[24]=0; scorey[24]=0; scorez[24]=2; check[24]=1;}
if (form.c26[0].checked==1) {scorex[25]=0; scorey[25]=-2; scorez[25]=0; check[25]=1;}
if (form.c26[1].checked==1) {scorex[25]=0; scorey[25]=-1; scorez[25]=0; check[25]=1;}
if (form.c26[2].checked==1) {scorex[25]=0; scorey[25]=1; scorez[25]=0; check[25]=1;}
if (form.c26[3].checked==1) {scorex[25]=0; scorey[25]=2; scorez[25]=0; check[25]=1;}
if (form.c27[0].checked==1) {scorex[26]=2; scorey[26]=0; scorez[26]=0; check[26]=1;}
if (form.c27[1].checked==1) {scorex[26]=1; scorey[26]=0; scorez[26]=0; check[26]=1;}
if (form.c27[2].checked==1) {scorex[26]=-1; scorey[26]=0; scorez[26]=0; check[26]=1;}
if (form.c27[3].checked==1) {scorex[26]=-2; scorey[26]=0; scorez[26]=0; check[26]=1;}
if (form.c28[0].checked==1) {scorex[27]=0; scorey[27]=2; scorez[27]=0; check[27]=1;}
if (form.c28[1].checked==1) {scorex[27]=0; scorey[27]=1; scorez[27]=0; check[27]=1;}
if (form.c28[2].checked==1) {scorex[27]=0; scorey[27]=-1; scorez[27]=0; check[27]=1;}
if (form.c28[3].checked==1) {scorex[27]=0; scorey[27]=-2; scorez[27]=0; check[27]=1;}
if (form.c29[0].checked==1) {scorex[28]=-2; scorey[28]=0; scorez[28]=0; check[28]=1;}
if (form.c29[1].checked==1) {scorex[28]=-1; scorey[28]=0; scorez[28]=0; check[28]=1;}
if (form.c29[2].checked==1) {scorex[28]=1; scorey[28]=0; scorez[28]=0; check[28]=1;}
if (form.c29[3].checked==1) {scorex[28]=2; scorey[28]=0; scorez[28]=0; check[28]=1;}
if (form.c30[0].checked==1) {scorex[29]=0; scorey[29]=0; scorez[29]=2; check[29]=1;}
if (form.c30[1].checked==1) {scorex[29]=0; scorey[29]=0; scorez[29]=1; check[29]=1;}
if (form.c30[2].checked==1) {scorex[29]=0; scorey[29]=0; scorez[29]=-1; check[29]=1;}
if (form.c30[3].checked==1) {scorex[29]=0; scorey[29]=0; scorez[29]=-2; check[29]=1;}
if (form.c31[0].checked==1) {scorex[30]=0; scorey[30]=2; scorez[30]=0; check[30]=1;}
if (form.c31[1].checked==1) {scorex[30]=0; scorey[30]=1; scorez[30]=0; check[30]=1;}
if (form.c31[2].checked==1) {scorex[30]=0; scorey[30]=-1; scorez[30]=0; check[30]=1;}
if (form.c31[3].checked==1) {scorex[30]=0; scorey[30]=-2; scorez[30]=0; check[30]=1;}
if (form.c32[0].checked==1) {scorex[31]=2; scorey[31]=0; scorez[31]=0; check[31]=1;}
if (form.c32[1].checked==1) {scorex[31]=1; scorey[31]=0; scorez[31]=0; check[31]=1;}
if (form.c32[2].checked==1) {scorex[31]=-1; scorey[31]=0; scorez[31]=0; check[31]=1;}
if (form.c32[3].checked==1) {scorex[31]=-2; scorey[31]=0; scorez[31]=0; check[31]=1;}
if (form.c33[0].checked==1) {scorex[32]=0; scorey[32]=0; scorez[32]=2; check[32]=1;}
if (form.c33[1].checked==1) {scorex[32]=0; scorey[32]=0; scorez[32]=1; check[32]=1;}
if (form.c33[2].checked==1) {scorex[32]=0; scorey[32]=0; scorez[32]=-1; check[32]=1;}
if (form.c33[3].checked==1) {scorex[32]=0; scorey[32]=0; scorez[32]=-2; check[32]=1;}
if (form.c34[0].checked==1) {scorex[33]=0; scorey[33]=-2; scorez[33]=0; check[33]=1;}
if (form.c34[1].checked==1) {scorex[33]=0; scorey[33]=-1; scorez[33]=0; check[33]=1;}
if (form.c34[2].checked==1) {scorex[33]=0; scorey[33]=1; scorez[33]=0; check[33]=1;}
if (form.c34[3].checked==1) {scorex[33]=0; scorey[33]=2; scorez[33]=0; check[33]=1;}
if (form.c35[0].checked==1) {scorex[34]=-2; scorey[34]=0; scorez[34]=0; check[34]=1;}
if (form.c35[1].checked==1) {scorex[34]=-1; scorey[34]=0; scorez[34]=0; check[34]=1;}
if (form.c35[2].checked==1) {scorex[34]=1; scorey[34]=0; scorez[34]=0; check[34]=1;}
if (form.c35[3].checked==1) {scorex[34]=2; scorey[34]=0; scorez[34]=0; check[34]=1;}
if (form.c36[0].checked==1) {scorex[35]=0; scorey[35]=2; scorez[35]=0; check[35]=1;}
if (form.c36[1].checked==1) {scorex[35]=0; scorey[35]=1; scorez[35]=0; check[35]=1;}
if (form.c36[2].checked==1) {scorex[35]=0; scorey[35]=-1; scorez[35]=0; check[35]=1;}
if (form.c36[3].checked==1) {scorex[35]=0; scorey[35]=-2; scorez[35]=0; check[35]=1;}
if (form.c37[0].checked==1) {scorex[36]=2; scorey[36]=0; scorez[36]=0; check[36]=1;}
if (form.c37[1].checked==1) {scorex[36]=1; scorey[36]=0; scorez[36]=0; check[36]=1;}
if (form.c37[2].checked==1) {scorex[36]=-1; scorey[36]=0; scorez[36]=0; check[36]=1;}
if (form.c37[3].checked==1) {scorex[36]=-2; scorey[36]=0; scorez[36]=0; check[36]=1;}
if (form.c38[0].checked==1) {scorex[37]=0; scorey[37]=0; scorez[37]=2; check[37]=1;}
if (form.c38[1].checked==1) {scorex[37]=0; scorey[37]=0; scorez[37]=1; check[37]=1;}
if (form.c38[2].checked==1) {scorex[37]=0; scorey[37]=0; scorez[37]=-1; check[37]=1;}
if (form.c38[3].checked==1) {scorex[37]=0; scorey[37]=0; scorez[37]=-2; check[37]=1;}
if (form.c39[0].checked==1) {scorex[38]=0; scorey[38]=2; scorez[38]=0; check[38]=1;}
if (form.c39[1].checked==1) {scorex[38]=0; scorey[38]=1; scorez[38]=0; check[38]=1;}
if (form.c39[2].checked==1) {scorex[38]=0; scorey[38]=-1; scorez[38]=0; check[38]=1;}
if (form.c39[3].checked==1) {scorex[38]=0; scorey[38]=-2; scorez[38]=0; check[38]=1;}
if (form.c40[0].checked==1) {scorex[39]=2; scorey[39]=0; scorez[39]=0; check[39]=1;}
if (form.c40[1].checked==1) {scorex[39]=1; scorey[39]=0; scorez[39]=0; check[39]=1;}
if (form.c40[2].checked==1) {scorex[39]=-1; scorey[39]=0; scorez[39]=0; check[39]=1;}
if (form.c40[3].checked==1) {scorex[39]=-2; scorey[39]=0; scorez[39]=0; check[39]=1;}
if (form.c41[0].checked==1) {scorex[40]=0; scorey[40]=0; scorez[40]=2; check[40]=1;}
if (form.c41[1].checked==1) {scorex[40]=0; scorey[40]=0; scorez[40]=1; check[40]=1;}
if (form.c41[2].checked==1) {scorex[40]=0; scorey[40]=0; scorez[40]=-1; check[40]=1;}
if (form.c41[3].checked==1) {scorex[40]=0; scorey[40]=0; scorez[40]=-2; check[40]=1;}
if (form.c42[0].checked==1) {scorex[41]=0; scorey[41]=-2; scorez[41]=0; check[41]=1;}
if (form.c42[1].checked==1) {scorex[41]=0; scorey[41]=-1; scorez[41]=0; check[41]=1;}
if (form.c42[2].checked==1) {scorex[41]=0; scorey[41]=1; scorez[41]=0; check[41]=1;}
if (form.c42[3].checked==1) {scorex[41]=0; scorey[41]=2; scorez[41]=0; check[41]=1;}
if (form.c43[0].checked==1) {scorex[42]=-2; scorey[42]=0; scorez[42]=0; check[42]=1;}
if (form.c43[1].checked==1) {scorex[42]=-1; scorey[42]=0; scorez[42]=0; check[42]=1;}
if (form.c43[2].checked==1) {scorex[42]=1; scorey[42]=0; scorez[42]=0; check[42]=1;}
if (form.c43[3].checked==1) {scorex[42]=2; scorey[42]=0; scorez[42]=0; check[42]=1;}
if (form.c44[0].checked==1) {scorex[43]=0; scorey[43]=2; scorez[43]=0; check[43]=1;}
if (form.c44[1].checked==1) {scorex[43]=0; scorey[43]=1; scorez[43]=0; check[43]=1;}
if (form.c44[2].checked==1) {scorex[43]=0; scorey[43]=-1; scorez[43]=0; check[43]=1;}
if (form.c44[3].checked==1) {scorex[43]=0; scorey[43]=-2; scorez[43]=0; check[43]=1;}
if (form.c45[0].checked==1) {scorex[44]=-2; scorey[44]=0; scorez[44]=0; check[44]=1;}
if (form.c45[1].checked==1) {scorex[44]=-1; scorey[44]=0; scorez[44]=0; check[44]=1;}
if (form.c45[2].checked==1) {scorex[44]=1; scorey[44]=0; scorez[44]=0; check[44]=1;}
if (form.c45[3].checked==1) {scorex[44]=2; scorey[44]=0; scorez[44]=0; check[44]=1;}
if (form.c46[0].checked==1) {scorex[45]=0; scorey[45]=0; scorez[45]=-2; check[45]=1;}
if (form.c46[1].checked==1) {scorex[45]=0; scorey[45]=0; scorez[45]=-1; check[45]=1;}
if (form.c46[2].checked==1) {scorex[45]=0; scorey[45]=0; scorez[45]=1; check[45]=1;}
if (form.c46[3].checked==1) {scorex[45]=0; scorey[45]=0; scorez[45]=2; check[45]=1;}
if (form.c47[0].checked==1) {scorex[46]=0; scorey[46]=-2; scorez[46]=0; check[46]=1;}
if (form.c47[1].checked==1) {scorex[46]=0; scorey[46]=-1; scorez[46]=0; check[46]=1;}
if (form.c47[2].checked==1) {scorex[46]=0; scorey[46]=1; scorez[46]=0; check[46]=1;}
if (form.c47[3].checked==1) {scorex[46]=0; scorey[46]=2; scorez[46]=0; check[46]=1;}
if (form.c48[0].checked==1) {scorex[47]=2; scorey[47]=0; scorez[47]=0; check[47]=1;}
if (form.c48[1].checked==1) {scorex[47]=1; scorey[47]=0; scorez[47]=0; check[47]=1;}
if (form.c48[2].checked==1) {scorex[47]=-1; scorey[47]=0; scorez[47]=0; check[47]=1;}
if (form.c48[3].checked==1) {scorex[47]=-2; scorey[47]=0; scorez[47]=0; check[47]=1;}
if (form.c49[0].checked==1) {scorex[48]=0; scorey[48]=-2; scorez[48]=0; check[48]=1;}
if (form.c49[1].checked==1) {scorex[48]=0; scorey[48]=-1; scorez[48]=0; check[48]=1;}
if (form.c49[2].checked==1) {scorex[48]=0; scorey[48]=1; scorez[48]=0; check[48]=1;}
if (form.c49[3].checked==1) {scorex[48]=0; scorey[48]=2; scorez[48]=0; check[48]=1;}
if (form.c50[0].checked==1) {scorex[49]=2; scorey[49]=0; scorez[49]=0; check[49]=1;}
if (form.c50[1].checked==1) {scorex[49]=1; scorey[49]=0; scorez[49]=0; check[49]=1;}
if (form.c50[2].checked==1) {scorex[49]=-1; scorey[49]=0; scorez[49]=0; check[49]=1;}
if (form.c50[3].checked==1) {scorex[49]=-2; scorey[49]=0; scorez[49]=0; check[49]=1;}


for (i=roll_call;i>0;i--)
{
totalx+=scorex[i-1]
totaly+=scorey[i-1]
totalz+=scorez[i-1]
};    

totalx=Math.round(totalx)/20;
totaly=Math.round(totaly)/20;
totalz=Math.round(totalz)/10;
form.answer.value="政治立场坐标（左翼<->右翼）"+totalx+"，经济立场坐标（左翼<->右翼）"+totaly+"，文化立场坐标（保守<->自由）"+totalz;

for (i=roll_call;i>0;i--)
{
if (check[i-1]==0){form.answer.value="您需要回答第"+i+"题";}
};

}



