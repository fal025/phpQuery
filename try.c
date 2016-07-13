//this file is used to get a array form in php

#include<stdio.h>
#include<stdlib.h>
#include<string.h>

#define FILENAME "nhanes_ids.txt"

int main()
{
    FILE* fp1 = fopen(FILENAME, "r");

    int ids[2504];
    memset(ids,0,sizeof(ids));
    int index = 0;
    while(index < 2504)
    {
        fscanf(fp1, "%d",&ids[index]);
        index++;
    }

    index = 0;
    FILE* fp2 = fopen("result", "w");
    fprintf(fp2, "$allId = [");
    while(index < 2504)
    {
        fprintf(fp2,"%d, ", ids[index]);
        if(index % 10 == 0)
            fprintf(fp2, "\n");
        index ++;
    }

    fprintf(fp2, "];");

    return 0;
}
