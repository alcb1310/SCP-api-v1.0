import axios from "axios";
import React, { useState, useEffect } from "react";
import Header from "../components/Header";
import { Spinner, Container } from "reactstrap";
import implantacion from "../images/implantacion.webp";
import Footer from "../components/Footer";
import Obra from "./Obra";

function HomePage({ username, logout }) {
  const [name, setName] = useState("");
  const [isLoading, setIsLoading] = useState(false);
  const [menuItem, setMenuItem] = useState("sistemacontrolprespuestario");

  useEffect(() => {
    setIsLoading(true);
    axios
      .get("/api/users", { username })
      .then((d) => setName(d.data["hydra:member"][0].nombre))
      .finally(setIsLoading(false));
  }, [username]);

  function changeMenu(event) {
    const option = event.target.textContent.toLowerCase().split(" ").join("");
    if (option === "sistemacontrolpresupuestario") {
      console.log(option);
      setMenuItem("");
    } else {
      setMenuItem(option);
    }
  }

  const spin = isLoading && (
    <Spinner color="secondary" size="">
      Loading...
    </Spinner>
  );

  const home = menuItem === "sistemacontrolprespuestario" && (
    <Container className="app-centered">
      {spin}
      <img src={implantacion} alt="Implantacion de cantagua II" />
    </Container>
  );
  const obra = menuItem === "obra" && <Obra />;

  return (
    <div>
      <Header name={name} logout={logout} changeMenu={changeMenu} />
      <main>
        {home}
        {obra}
      </main>
      <Footer />
    </div>
  );
}

export default HomePage;
