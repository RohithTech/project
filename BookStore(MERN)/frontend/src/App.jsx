import React from "react";
import { Route, Routes } from "react-router-dom";
import Createbook from "./pages/Createbook";
import Deletebook from "./pages/Deletebook";
import Showbook from "./pages/Showbook";
import Editbook from "./pages/Editbook";
import Home from "./pages/Home";

function App() {
  return (
    <Routes>
      <Route path="/" element={<Home />} />
      <Route path="/books/create" element={<Createbook />} />
      <Route path="/books/details/:id" element={<Showbook />} />
      <Route path="/books/edit/:id" element={<Editbook />} />
      <Route path="/books/delete/:id" element={<Deletebook />} />
    </Routes>
  );
}

export default App;
