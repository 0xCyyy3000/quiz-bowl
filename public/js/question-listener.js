import { readFile, writeFile } from "fs";
const path = './data.json';

readFile(path, (error, data) => {
    if (error) {
        console.log(error);
        return;
    }
    console.log(data);
});

writeFile(path, JSON.stringify(parsedData, null, 2), (error) => {
    if (error) {
        console.log(error);
        return;
    }
});