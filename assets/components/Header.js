import React from "react";
import PropTypes from "prop-types";
import {
  Container,
  Nav,
  Navbar,
  NavItem,
  NavLink,
  Row,
  Col,
  UncontrolledDropdown,
  DropdownToggle,
  DropdownMenu,
  DropdownItem,
  NavbarBrand,
} from "reactstrap";

function Header({ name, logout, changeMenu }) {
  return (
    <header>
      <Navbar style={{ backgroundColor: "rgb(0, 102, 153)" }} dark expand="md">
        <Container>
          <Row className="position-relative w-100 align-items-center">
            <Col className="d-none d-lg-flex justify-content-start">
              <Nav className="mrx-auto" navbar>
                <NavbarBrand onClick={changeMenu}>
                  Sistema Control Prespuestario
                </NavbarBrand>
                <UncontrolledDropdown inNavbar nav>
                  <DropdownToggle caret nav style={{ color: "var(--white)" }}>
                    Transacciones
                  </DropdownToggle>
                  <DropdownMenu>
                    <DropdownItem onClick={changeMenu}>Obra</DropdownItem>
                    <DropdownItem divider />
                    <DropdownItem onClick={changeMenu}>
                      Presupuesto
                    </DropdownItem>
                    <DropdownItem onClick={changeMenu}>Factura</DropdownItem>
                    <DropdownItem onClick={changeMenu}>
                      Cierre de mes
                    </DropdownItem>
                    <DropdownItem onClick={changeMenu}>
                      Avance de obra
                    </DropdownItem>
                    <DropdownItem onClick={changeMenu}>Flujo</DropdownItem>
                  </DropdownMenu>
                </UncontrolledDropdown>

                <UncontrolledDropdown inNavbar nav>
                  <DropdownToggle caret nav style={{ color: "var(--white)" }}>
                    Reportes
                  </DropdownToggle>
                  <DropdownMenu>
                    <DropdownItem onClick={changeMenu}>Cuadre</DropdownItem>
                    <DropdownItem onClick={changeMenu}>
                      Gastado en el mes
                    </DropdownItem>
                    <DropdownItem divider />
                    <DropdownItem onClick={changeMenu}>
                      Control Actual
                    </DropdownItem>
                    <DropdownItem onClick={changeMenu}>
                      Control por Fechas
                    </DropdownItem>
                    <DropdownItem divider />
                    <DropdownItem onClick={changeMenu}>
                      Gastado mensual
                    </DropdownItem>
                    <DropdownItem onClick={changeMenu}>
                      Presupuesto vs. Ejecutado
                    </DropdownItem>
                  </DropdownMenu>
                </UncontrolledDropdown>

                <UncontrolledDropdown inNavbar nav>
                  <DropdownToggle caret nav style={{ color: "var(--white)" }}>
                    Parámetros
                  </DropdownToggle>
                  <DropdownMenu>
                    <DropdownItem onClick={changeMenu}>Partidas</DropdownItem>
                    <DropdownItem onClick={changeMenu}>Proveedor</DropdownItem>
                  </DropdownMenu>
                </UncontrolledDropdown>
                <NavItem className="d-flex align-items-center">
                  <NavLink
                    className="font-weight-bold"
                    href="#"
                    onClick={logout}
                    style={{ color: "var(--white)" }}
                  >
                    Salir
                  </NavLink>
                </NavItem>
              </Nav>
            </Col>
          </Row>
        </Container>
      </Navbar>
      <Row className="mt-2">
        <Col md={{ offset: 2, size: 8 }}>
          <p className="app-welcome">Bienvenido {name}</p>
        </Col>
      </Row>
    </header>
  );
}

Header.propTypes = {
  name: PropTypes.string.isRequired,
  logout: PropTypes.func.isRequired,
  changeMenu: PropTypes.func.isRequired,
};

export default Header;
