import {Routes, Route} from "react-router-dom";
//Pages
import Add from "../pages/Add";
import List from "../pages/List";
import {useEffect} from "react";
function Router() {

    return (
        <Routes>
            <Route path="/add" element={<Add/>} />
            <Route path="/list" element={<List/>} />
        </Routes>
    );
}
export default Router;