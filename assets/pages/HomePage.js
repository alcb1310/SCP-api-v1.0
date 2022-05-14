import axios from "axios";
import React, { useState, useEffect } from "react";
import PropTypes from "prop-types";
import { Spinner, Container } from "reactstrap";

import Header from "../components/Header";
import implantacion from "../images/implantacion.webp";
import Footer from "../components/Footer";
import Obra from "./Obra";
import Partida from "./Partida";
import Proveedor from "./Proveedor";

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
  const partida = menuItem === "partidas" && <Partida />;
  const proveedor = menuItem === "proveedor" && <Proveedor />;

  return (
    <div>
      <Header name={name} logout={logout} changeMenu={changeMenu} />
      <main>
        {home}
        {obra}
        {partida}
        {proveedor}
      </main>
      <Footer />
    </div>
  );
}

HomePage.propTypes = {
  username: PropTypes.string.isRequired,
  logout: PropTypes.func.isRequired,
};

export default HomePage;
