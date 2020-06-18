const AccessLevels = {
    [1 as number]: "Student" as string,
    [2 as number]: "Faculty" as string,
    [3 as number]: "Administrator" as string,
    ["Student" as string]: 1 as number,
    ["Faculty" as string]: 2 as number,
    ["Administrator" as string]: 3 as number
};

export default AccessLevels;
