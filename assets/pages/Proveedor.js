import axios from "axios";
import React, { useState, useEffect } from "react";
import ReactPaginate from "react-paginate";
import { Button, Col, Row, Table, Input } from "reactstrap";
import ProveedorForm from "../components/ProveedorForm";

function Proveedor() {
  const [proveedores, setProveedores] = useState([]);
  const [maxPages, setMaxPages] = useState(0);
  const [showForm, setShowForm] = useState(false);
  const [isEdit, setIsEdit] = useState(false);
  const [loadProveedor, setLoadProveedor] = useState(false);
  const [params, setParams] = useState({});
  const [selectedProveedor, setSelectedProveedor] = useState({});
  const [searchTerms, setSearchTerms] = useState("");
  const url = "/api/proveedors";

  useEffect(() => {
    axios.get(url, { params }).then((d) => {
      setProveedores(d.data["hydra:member"]);
      if (d.data["hydra:view"] && d.data["hydra:view"]["hydra:last"]) {
        let p = d.data["hydra:view"]["hydra:last"].search("page=");
        let number = d.data["hydra:view"]["hydra:last"].slice(p + 5);
        p = number.indexOf("?");
        if (p === -1) {
          setMaxPages(parseInt(number));
        } else {
          number = number.slice(0, p);
          setMaxPages(parseInt(number));
        }
      }
    });
  }, [params, loadProveedor]);

  function toggleLoadProveedor() {
    setLoadProveedor((prevLoad) => !prevLoad);
  }

  function handlePageClick(event) {
    const page = event.selected + 1;
    setParams((prevParams) => ({ ...prevParams, page }));
  }

  function handleChange(event) {
    setSearchTerms(event.target.value);
    setParams({ search: event.target.value });
  }

  function addProveedor() {
    setIsEdit(false);
    setShowForm(true);
  }

  function editProveedor(id) {
    setIsEdit(true);
    setSelectedProveedor(
      proveedores.find((proveedor) => proveedor["@id"] === id)
    );
    setShowForm(true);
  }

  function closeForm() {
    setIsEdit(false);
    setShowForm(false);
    setSelectedProveedor({});
  }

  const proveedoresEl = proveedores.map((proveedor) => {
    return (
      <tr
        key={proveedor["@id"]}
        onClick={() => editProveedor(proveedor["@id"])}
      >
        <td>{proveedor.ruc}</td>
        <td>{proveedor.nombre}</td>
        <td>{proveedor.contacto}</td>
        <td>{proveedor.telefono}</td>
        <td>{proveedor.email}</td>
      </tr>
    );
  });

  const proveedorForm = showForm && (
    <ProveedorForm
      isEdit={isEdit}
      closeForm={closeForm}
      toggleLoadProveedor={toggleLoadProveedor}
      selectedProveedor={selectedProveedor}
    />
  );

  return (
    <>
      <Row>
        <Col md={{ offset: 2, size: 8 }}>{proveedorForm}</Col>
      </Row>
      <Row>
        <Col md={{ offset: 2, size: 6 }}>
          <h3>Proveedor</h3>
        </Col>
        <Col md={2}>
          <Button color="primary" outline onClick={addProveedor}>
            Agregar
          </Button>
        </Col>
      </Row>
      <Row>
        <Col md={{ offset: 2, size: 6 }}>
          <ReactPaginate
            pageCount={maxPages}
            breakLabel="..."
            nextLabel=">>"
            onPageChange={handlePageClick}
            pageRangeDisplayed={3}
            previousLabel="<<"
            renderOnZeroPageCount={null}
            containerClassName="pagination pagination-sm"
            pageClassName="page-item"
            pageLinkClassName="page-link"
            previousClassName="page-item"
            nextClassName="page-item"
            previousLinkClassName="page-link"
            nextLinkClassName="page-link"
            activeLinkClassName="active"
            activeClassName="active"
          />
        </Col>
        <Col md={2}>
          <Input
            type="text"
            placeholder="Busqueda"
            name="search"
            id="search"
            onChange={handleChange}
            value={searchTerms}
          />
        </Col>
      </Row>
      <Row>
        <Col md={{ offset: 2, size: 8 }}>
          <Table hover size="sm">
            <thead>
              <tr>
                <td>RUC</td>
                <td>Nombre</td>
                <td>Contacto</td>
                <td>Tel??fono</td>
                <td>E-mail</td>
              </tr>
            </thead>
            <tbody>{proveedoresEl}</tbody>
          </Table>
        </Col>
      </Row>
    </>
  );
}

export default Proveedor;
